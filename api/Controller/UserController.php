<?php

require_once ROOT . '/Controller/BaseController.php';
require_once ROOT . '/Model/UserModel.php';

/**
 * Class UserController
 *
 * Recebe as requisições diretamente do controller principal para a rota de User (/user)
 *
 * @package Controller\
 * @see Controller\BaseController
 * @see Model\UserModel
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class UserController extends BaseController
{
    /**
     * Tratamento de requisições do tipo GET genéricas
     *
     * Opções possíveis:
     * /id:numero => busca direto pelo id
     * / => busca todos os registros
     * /limit:numero/offfset:numero => busca todos os registros restritos por limite e offset
     * /busca/criterio:texto/[pagina:numero] => busca por critério e efetua paginação
     *
     * Overrides:
     * @see Controller\BaseController->get()
     *
     * Mensagens:
     * @see App\Utils::$arr_message_pattern
     * @see App\Utils::$arr_message_content_pattern
     *
     * Parâmetros por URL
     * @see App\Controller->generate_route_path()
     *
     * @param  array $arr_data Array contendo os parâmetros passados pela URL:
     *                           Lista ou busca por ID: [0] => id, [1] => limit, [2] => offset
     *                           Lista de busca por texto: [0] => busca, [1] => texto, [2] => página
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
        // indicador de busca textual
        $bol_search = false;
        // Texto para busca
        $str_text_search = "";
        $str_param_one = $arr_data[0] ?? '';
        $str_param_two = $arr_data[1] ?? '';
        $str_param_three = $arr_data[2] ?? '';
        $bol_error = false;

        //Regra: Verifica se o parâmetro um não está vazio (foi passada alguma informação)
        if (!empty($str_param_one)) {

            // Regra: verifica se o parâmetro um == 'busca' (/busca/)
            if ($str_param_one == 'busca') {

                //Regra: verifica se foi passado o segundo parâmetro (/busca/[critério:texto])
                if (!empty($str_param_two) && !is_numeric($str_param_two)) {
                    $bol_search = true;
                    $str_text_search = $str_param_two;

                    // cria objeto UserModel para recuperar informação do tamanho da página
                    $obj_tmp = new UserModel();
                    $int_limit = (int)$obj_tmp->int_pagesize;

                    // Regra: verifica se existe o parâmetro 3 e se é um número (/busca/[critério:texto]/[página:numero])
                    if (!empty($str_param_three)) {

                        if (is_numeric($str_param_three)) {
                            $int_offset = ((int)$str_param_three * $int_limit);

                        } else {
                            $bol_error = true;
                            $this->return[422] = "Search page needs to be a number";
                        }
                    }

                    // destrói objeto
                    unset($obj_tmp);

                } else {
                    $bol_error = true;
                    $this->return[422] = "Search criteria needs to be filled and cannot be a numeric value";
                }


            } else {
                // Regra: verifica se o parâmetro um é um número e o parâmetro dois vazio, representando recuperar um só registro (/[id:numero])
                if (is_numeric($str_param_one)) {

                    if (empty($str_param_two)) {
                        $int_id = (int)$str_param_one;
                    } else {

                        if (is_numeric($str_param_two)) {
                            $int_limit = (int)$str_param_one;
                            $int_offset = (int)$str_param_two;

                            if ($int_id === 0 && $int_offset === 0 && $int_limit === 0) {
                                $bol_error = true;
                                $this->return[422] = "Limit and Offset needs to have a numeric value";
                            } elseif ($int_id === 0 && empty($str_param_two) && empty($str_param_three)) {
                                $bol_error = true;
                                $this->return[422] = "Record id needs to be a number";
                            }

                        }

                    }
                } else {
                    $bol_error = true;
                    $this->return[422] = "Record id needs to be a number";
                }
            }
        }


        // não ocorrendo nenhuma mensagem, significa que passou nas validações
        // então retorna uma nova consulta
        if ($bol_error === false) {
            $obj_model = new $this->str_model_name();
            $results = $obj_model->get($int_id, $int_limit, $int_offset, $bol_search, $str_text_search);

            // monta mensagem padrão para a resposta
            $arr_content = Utils::$arr_message_content_pattern;

            // somente inclui os labels na mensagem quando retornar pelo menos
            // uma linha de resultado
            if (count($results) > 0) {
                $arr_content['labels'] = $obj_model->arr_table_fields;
                $arr_content['results'] = $int_id == 0 ? count($results) : 1;
                // adiciona o marcador da página atual, no caso de busca textual
                if ($bol_search === true) {
                    $arr_content['page'] = (int)$str_param_three == 0 ? 1 : (int)$str_param_three;
                }
            } elseif (count($results) == 0 && !empty($obj_model->return)) {
                $this->return[500] = $obj_model->return;
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
        return [false];
    }

    /**
     * Tratamento de requisições do tipo PUT genéricas
     *
     * @param array $arr_data Array contendo os parâmetros passados por PUT
     * @return array          Array formatado conforme padrão da Classe Utils
     */
    public function put(array $arr_data = []): array
    {
        return [false];
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
        return [false];
    }

}