<?php

require_once ROOT . '/App/Db.php';

/**
 * Class DbModel
 *
 * Classe padrão para interagir com o banco de dados e com todas as ações possíveis (insert, update, delete, put, ...)
 *
 * @package Model\
 * @see App\Db
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class DbModel
{
    // Armazena o nome da classe do Model
    public $str_table_name = "";
    // Armazena os nomes dos campos na tabela e em tela (nome_tabela => 'Nome na Tela')
    public $arr_table_fields = [];
    // Armazena os nomes dos campos indexados para FULLTEXT
    public $arr_table_fields_fulltext = [];
    // Armazena as regras de validação para o modelo de dados
    public $arr_validation_rules = [];
    // Armazena a ordem dos campos na busca
    public $arr_table_fields_order = [];
    // Armazena o tamanho da página para exibir resultados (paginação)
    public $int_pagesize = 0;
    // armazena mensagens erro
    public $return = "";

    /**
     * Recupera um registro pelo id, uma lista ou busca textual, podendo ser utilizado limite e/ou offset
     *
     * @param  int   $int_id     Id do registro a ser recuperado
     * @param  int   $int_limit  Limit ou registro no qual será iniciado a cadeia dos resultados
     * @param  int   $int_offset Offset ou quantidade de registros que terão no resultado
     * @param  bool  $bol_search Indicador de pesquisa textual
     * @return array             Array com informações diretas do banco de dados
     */
    public function get(int $int_id = 0, int $int_limit = 0, int $int_offset = 0,
                        bool $bol_search = false, string $str_text_search = ""): array {

        $ret = [];

        // insere o campo id no início do array dos campos para também ser retornado
        // nos resultados
        $this->arr_table_fields  = ['id' => "ID"] + $this->arr_table_fields;

        $str_fields = implode(', ', array_keys($this->arr_table_fields));
        $str_fields_fulltext = implode(', ', $this->arr_table_fields_fulltext);
        $str_where = "";
        $str_limit = "";
        $str_order = "";
        $arr_params = [];

        // verifica se é uma busca textual
        if ($bol_search == true) {
            $str_where = vsprintf(" WHERE MATCH(%s) AGAINST (:text IN NATURAL LANGUAGE MODE)", [$str_fields_fulltext]);
            $arr_params[':text'] = rawurldecode($str_text_search);

            $str_order = " ORDER BY :order_by ASC";
            $arr_params[':order_by'] = implode(', ', $this->arr_table_fields_order);
        }

        // verifica se foi inserido o id
        if ($int_id > 0)  {
            $str_where = ' WHERE id = :id';
            $arr_params[':id'] = $int_id;
        }

        // verifica se foi inserido o limit
        if ($int_limit > 0 && $int_id === 0) {
            $str_limit = ' LIMIT :offset, :limit';
            $arr_params[':offset'] = $int_offset;
            $arr_params[':limit'] = $int_limit;
        }

        // monta a query com os valores inseridos
        $str_query = vsprintf('SELECT %s FROM %s%s%s%s', [
            $str_fields, $this->str_table_name, $str_where, $str_order, $str_limit
            ]
        );

        // inicia um objeto de conexão PDO
        $res_con = new Db();

        // verifica se ocorreu algum problema de conexão com o banco de dados
        if ($res_con !== false)  {

            try {
                // insere a query no objeto PDO
                $res_stmt = $res_con->res_pdo->prepare($str_query);
                // insere os parâmetros no objeto PDO e executa a query
                $res_stmt->execute($arr_params);

                if ($int_id == 0) {
                    $arr_result = $res_stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $arr_result = $res_stmt->fetch(PDO::FETCH_ASSOC);
                }

                // se não ocorreu algum erro retorna os resultados
                if ($arr_result !== false) {
                    $ret = $arr_result;
                } else {
                    $this->return = "Query failed.";
                }

            } catch (Exception $e) {
                $this->return = $e->getMessage();
            }

        // se sim recupera o erro da classe Db
        } else {
            $this->return = $res_con->return;
        }

        unset($res_con);

        return $ret;

    }

    /**
     * Insere um registro baseado em um array com informações de um POST e na lista de campos (@see Model\[URL]Model)
     *
     * @param  array $arr_post Informações vinda via POST
     * @return array           Array com informações diretas do banco de dados
     */
    public function post(array $arr_post = []): array
    {
        $ret = [];

        // cria string com as colunas da tabela
        $str_fields = implode(', ', array_keys($this->arr_table_fields));
        $arr_params = [];

        // itera sob a lista de campos e cria lista com campos e valores para serem inseridos na query
        // como prepared statement
        foreach ($this->arr_table_fields as $key => $value) {
            $arr_params[':' . $key] = $arr_post[$key];
        }

        // cria uma string para adicionar à string de query (:campo, :campo1, ...)
        $str_values = implode(', ', array_keys($arr_params));

        // monta a query com os valores inseridos
        $str_query = vsprintf('INSERT INTO %s (%s) VALUES (%s)', [$this->str_table_name, $str_fields, $str_values]);

        // inicia um objeto de conexão PDO
        $res_con = new Db();

        // verifica se ocorreu algum problema de conexão com o banco de dados
        if ($res_con !== false)  {

            try {
                // insere a query no objeto PDO
                $res_stmt = $res_con->res_pdo->prepare($str_query);
                // insere os parâmetros no objeto PDO e executa a query
                $res_stmt->execute($arr_params);

                // $arr_result = $res_stmt->fetch(PDO::FETCH_ASSOC);

                // recupera o id do último registro inserido
                $int_last_id = $res_con->res_pdo->lastInsertId();

                // se não ocorreu algum erro retorna os resultados
                if ($res_stmt !== false) {
                    // recupera o último registro inserido
                     $str_query_retr = vsprintf('SELECT %s FROM %s WHERE id = :id', ['id, ' . $str_fields, $this->str_table_name]);

                     $res_stmt_retr = $res_con->res_pdo->prepare($str_query_retr);
                     $res_stmt_retr->execute([':id' => $int_last_id]);

                     $arr_result = $res_stmt_retr->fetch(PDO::FETCH_ASSOC);

                    // se não ocorreu algum erro retorna os resultados
                    if ($arr_result !== false) {
                        $ret = $arr_result;
                    } else {
                        $this->return = "Record inserted but wasn't possible to retrieve data.";
                    }

                } else {
                    $this->return = "Failed to insert data.";
                }

            } catch (Exception $e) {
                $this->return = $e->getMessage();
            }

            // se sim recupera o erro da classe Db
        } else {
            $this->return = $res_con->return;
        }

        unset($res_con);

        return $ret;
    }

    /**
     * Atualiza um registro baseado em um array com informações de um PUT e na lista de campos (@see Model\[URL]Model)
     *
     * @param  array $arr_put Informações vindas via PUT
     * @return array          Array com informações diretas do banco de dados do registro atualizado
     */
    public function put(array $arr_put = []): array
    {
        $ret = [];

        // armazena os dados das colunas para serem inseridos na string da query
        $arr_fields = [];
        // array com os parâmetros para executar o PDO
        $arr_params = [];
        // recupera o ID do registro
        $int_id = $arr_put['id'];

        // itera sob a lista de campos e cria lista com campos e valores para serem inseridos na query
        // como prepared statement
        foreach (['id' => $int_id] + $this->arr_table_fields as $key => $value) {
            $arr_params[':' . $key] = $arr_put[$key];
            // cria também a lista de campos para serem adicionados na string da query
            // excluindo o id
            if ($key != 'id') {
                $arr_fields[] = vsprintf('%s = %s', [$key, ':' . $key]);
            }
        }
        // cria string com as colunas da tabela
        $str_fields = implode(', ', $arr_fields);

        // monta a query com os valores inseridos
        $str_query = vsprintf('UPDATE %s SET %s WHERE id = :id', [$this->str_table_name, $str_fields]);

        // inicia um objeto de conexão PDO
        $res_con = new Db();

        // verifica se ocorreu algum problema de conexão com o banco de dados
        if ($res_con !== false)  {

            try {
                // insere a query no objeto PDO
                $res_stmt = $res_con->res_pdo->prepare($str_query);
                // insere os parâmetros no objeto PDO e executa a query
                $res_stmt->execute($arr_params);

                // se não ocorreu algum erro retorna os resultados
                if ($res_stmt !== false) {

                    // altera a lista de campos para somente o nome sem o wildcard de troca (:campo)
                    $str_fields = implode(', ', array_keys($this->arr_table_fields));

                    // recupera o registro alterado
                    $str_query_retr = vsprintf('SELECT %s FROM %s WHERE id = :id', ['id, ' . $str_fields, $this->str_table_name]);

                    $res_stmt_retr = $res_con->res_pdo->prepare($str_query_retr);
                    $res_stmt_retr->execute([':id' => $int_id]);

                    $arr_result = $res_stmt_retr->fetch(PDO::FETCH_ASSOC);

                    // se não ocorreu algum erro retorna os resultados
                    if ($arr_result !== false) {
                        $ret = $arr_result;
                    } else {
                        $this->return = "Record updated but wasn't possible to retrieve data.";
                    }

                } else {
                    $this->return = "Failed to update record.";
                }

            } catch (Exception $e) {
                $this->return = $e->getMessage();
            }

            // se sim recupera o erro da classe Db
        } else {
            $this->return = $res_con->return;
        }

        unset($res_con);

        return $ret;
    }

    /**
     * Apaga (soft-delete) um registro baseado no ID vindo através de uma rquisição DELETE
     *
     * @param  array $arr_put Informações vindas via PUT
     * @return array          Array com informações diretas do banco de dados do registro atualizado
     */

    /**
     * Apaga (soft-delete) um registro baseado no ID vindo através de uma requisição DELETE
     *
     * @param  int   $int_id ID vindo através de uma requisição DELETE
     * @return array         Array com informações diretas do banco de dados do registro atualizado
     */
    public function delete(int $int_id = 0): array
    {
        $ret = [];

        // monta a query com os valores inseridos
        $str_query = vsprintf('UPDATE %s SET ativo = 0 WHERE id = :id', [$this->str_table_name]);

        // inicia um objeto de conexão PDO
        $res_con = new Db();

        // verifica se ocorreu algum problema de conexão com o banco de dados
        if ($res_con !== false)  {

            try {
                // insere a query no objeto PDO
                $res_stmt = $res_con->res_pdo->prepare($str_query);
                // insere os parâmetros no objeto PDO e executa a query
                $res_stmt->execute([':id' => $int_id]);

                // se não ocorreu algum erro retorna os resultados
                if ($res_stmt !== false) {

                    // altera a lista de campos para somente o nome sem o wildcard de troca (:campo)
                    $str_fields = implode(', ', array_keys($this->arr_table_fields));

                    // recupera o registro alterado
                    $str_query_retr = vsprintf('SELECT %s FROM %s WHERE id = :id', ['id, ' . $str_fields, $this->str_table_name]);

                    $res_stmt_retr = $res_con->res_pdo->prepare($str_query_retr);
                    $res_stmt_retr->execute([':id' => $int_id]);

                    $arr_result = $res_stmt_retr->fetch(PDO::FETCH_ASSOC);

                    // se não ocorreu algum erro retorna os resultados
                    if ($arr_result !== false) {
                        $ret = $arr_result;
                    } else {
                        $this->return = "Record deleted but wasn't possible to retrieve data.";
                    }

                } else {
                    $this->return = "Failed to delete record.";
                }

            } catch (Exception $e) {
                $this->return = $e->getMessage();
            }

        } else {
            $this->return = $res_con->return;
        }

        unset($res_con);

        return $ret;
    }
}