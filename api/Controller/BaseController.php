<?php

/**
 * Class BaseController
 *
 * Classe genérica que trata as requisições vindas do Controller principal e que é extendida para os controllers
 * gerais do sistema
 *
 * @package Controller\
 * @see Controller\
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class BaseController
{
    // armazena erros de execução
    public $return = [];
    // armazena o nome da classe extendida
    protected $str_model_name = "";

    /**
     * BaseController constructor.
     *
     * Determina o nome do Model em tempo de execução
     *
     * @param string $str_class_name
     */
    public function __construct(string $str_class_name)
    {
        $this->str_model_name = $str_class_name . "Model";
    }

    /**
     * Tratamento de requisições do tipo GET genéricas
     *
     * Opções possíveis:
     * /id:numero => busca direto pelo id
     * / => busca todos os registros
     * /limit:numero/offfset:numero => busca todos os registros restritos por limite e offset
     * /busca/criterio:texto/[pagina:numero] => busca por critério e efetua paginação
     *
     * Mensagens:
     * @see App\Utils::$arr_message_pattern
     * @see App\Utils::$arr_message_content_pattern
     *
     * Parâmetros por URL
     * @see App\Controller\generate_route_path()
     *
     * @param  array $arr_data Array contendo os parâmetros passados pela URL [0] => id, [1] => limit, [2] => offset
     * @return array           Array formatado conforme padrão da Classe Utils
     */
    public function get(array $arr_data = []): array
    {
        $ret = [];
        // id do registro, caso seja fornecido
        $int_id = 0;
        // informação do limit para a query
        $int_limit = 0;
        // informação do offset para a query
        $int_offset = 0;

        // se tiver um ou três parâmetros, utiliza somente o primeiro parâmetro como ID
        // um id somente não necessita de limit e offset
        if (count($arr_data) == 1 || count($arr_data) == 3) {
            $int_id = $arr_data[0];

            if (!is_numeric($int_id)) {
                $this->return[422] = "Record id needs to have a numeric value";
            }

        // se tiver dois ou mais que três parâmetros, compreende como limit e offset
        } elseif (count($arr_data) == 2 || count($arr_data) > 3) {
            $int_limit = $arr_data[0];
            $int_offset = $arr_data[1];

            if (!is_numeric($int_limit) || !is_numeric($int_offset)) {
                $this->return[422] = "Limit and Offset need to have a numeric value";
            }
        }

        // não ocorrendo nenhuma mensagem, significa que passou nas validações
        // então retorna uma nova consulta
        if (empty($this->return)) {
            $obj_model = new $this->str_model_name();
            $results = $obj_model->get($int_id, $int_limit, $int_offset);

            // monta mensagem padrão para a resposta
            $arr_content = Utils::$arr_message_content_pattern;

            // somente inclui os labels na mensagem quando retornar pelo menos
            // uma linha de resultado
            if (count($results) > 0) {
                $arr_content['labels'] = $obj_model->arr_table_fields;
                $arr_content['results'] = $int_id == 0 ? count($results) : 1;
            }

            $arr_content['data'] = $results;

            $ret = $arr_content;
        }

        return $ret;
    }

    /**
     * Tratamento de requisições do tipo POST genéricas
     *
     * @param array $arr_data Array contendo os parâmetros passados por POST
     * @return array          Array formatado conforme padrão da Classe Utils
     */
    public function post(array $arr_data = []): array
    {
        $ret = [];
        // Instancia o Model para recuperar informações
        $obj_model = new $this->str_model_name();
        // valida se a quantidade de informações são as mesmas necessárias
        if (count($arr_data) === count($obj_model->arr_table_fields)) {

            // valida os campos baseado nas informações vindas do Model
            $arr_validation = Utils::validate_post('post', $arr_data, $obj_model->arr_validation_rules,
                $obj_model->arr_table_fields);
            if (count($arr_validation) == 0) {

                // ocorrendo tudo bem, procede com o processo de inserção do registro
                $ret_tmp = $obj_model->post($arr_data);

                // valida se não ocorreu algum erro
                // se ocorreu erro, retorna a mensagem para o objeto
                if (!empty($obj_model->return)) {
                  $this->return[500] = $obj_model->return;
                } else {
                    // monta mensagem padrão para a resposta
                    $arr_content = Utils::$arr_message_content_pattern;
                    $arr_content['results'] = 1;
                    $arr_content['data'] = $ret_tmp;
                    $ret = $arr_content;
                }

            // contendo erros, expõe para o objeto o código e a mensagem
            } else {
                $this->return[key($arr_validation)] = $arr_validation[key($arr_validation)];
            }

        // se quantidade diferente retorna erro para o objeto
        } else {
            $this->return[422] = vsprintf('Fields amount sent are incorrect (%u expected, %u sent)',
                [count($obj_model->arr_table_fields), count($arr_data)]);
        }

        return $ret;
    }

    /**
     * Tratamento de requisições do tipo PUT genéricas
     *
     * @param array $arr_data Array contendo os parâmetros passados por PUT
     * @return array          Array formatado conforme padrão da Classe Utils
     */
    public function put(array $arr_data = []): array
    {
        $ret = [];
        $obj_model = new $this->str_model_name();
        // valida se a quantidade de informações são as mesmas necessárias
        if (count($arr_data) === count($obj_model->arr_table_fields + ['id'])) {

            // valida os campos baseado nas informações vindas do Model
            $arr_validation = Utils::validate_post('put', $arr_data, $obj_model->arr_validation_rules,
                $obj_model->arr_table_fields);
            if (count($arr_validation) == 0) {

                // ocorrendo tudo bem, procede com o processo de atualizar do registro
                $ret_tmp = $obj_model->put($arr_data);

                // valida se não ocorreu algum erro
                if (empty($obj_model->return)) {
                    // monta mensagem padrão para a resposta
                    $arr_content = Utils::$arr_message_content_pattern;
                    $arr_content['results'] = 1;
                    $arr_content['data'] = $ret_tmp;
                    $ret = $arr_content;
                // se ocorreu erro, retorna a mensagem para o objeto
                // contendo erros, expõe para o objeto o código e a mensagem
                } else {
                    $this->return[500] = $obj_model->return;
                }

            } else {
                $this->return[key($arr_validation)] = $arr_validation[key($arr_validation)];
            }

        // se quantidade diferente retorna erro para o objeto
        } else {
            $this->return[422] = vsprintf('Fields amount sent are incorrect (%u expected, %u sent)',
                [count($obj_model->arr_table_fields), count($obj_model->arr_table_fields + ['id'])]);
        }

        return $ret;
    }

    /**
     * Tratamento de requisições do tipo DELETE genéricas e efetua o soft delete de um registro (ativo = 0)
     *
     * Mensagens:
     * @see App\Utils::$arr_message_pattern
     * @see App\Utils::$arr_message_content_pattern
     *
     * Parâmetros por URL
     * @see App\Controller\generate_route_path()
     *
     * @param array $arr_data Array contendo os parâmetros passados por PUT
     * @return array          Array formatado conforme padrão da Classe Utils
     */
    public function delete(array $arr_data = []): array
    {
        $ret = [];

        $int_id = 0;

        // se tiver menos de um parâmetro o id  não foi passado
        // erro de parâmetro mandatório
        if (count($arr_data) == 0) {
            $this->return[422] = "Record id is mandatory";
        // senão valida se é um valor numérico
        } elseif (!is_numeric($arr_data[0])) {
            $this->return[422] = vsprintf("Record id needs to have a numeric value, %s given", [$arr_data[0]]);
        // por final altera o valor do id para o do registro que será apagado
        } else {
            $int_id = $arr_data[0];
        }

        // não ocorrendo nenhuma mensagem, significa que passou nas validações
        // então retorna o resultado da operação delete
        if (empty($this->return) && $int_id > 0) {
            $obj_model = new $this->str_model_name();
            $results = $obj_model->delete($int_id);

            // valida se não ocorreu algum erro
            if (empty($obj_model->return)) {
                // monta mensagem padrão para a resposta
                $arr_content = Utils::$arr_message_content_pattern;
                $arr_content['results'] = 1;
                $arr_content['data'] = $results;

                $ret = $arr_content;

            // se ocorreu erro, retorna a mensagem para o objeto
            // contendo erros, expõe para o objeto o código e a mensagem
            } else {
                $this->return[500] = $obj_model->return;
            }
        }

        return $ret;
    }
}