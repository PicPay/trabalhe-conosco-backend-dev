<?php

/**
 * Class Utils
 *
 * Classe com maior parte de métodos estáticos que são de uso comum em qualquer elemento do sistema
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class Utils
{

    /**
     * Template para cabeçalho da mensagem padrão para respostas
     *
     * @var array
     */
    public static $arr_message_pattern = [
        // código http de retorno
        'status' => 0,
        // tipo: success | error
        'type' => "",
        // mensagem quando necessário
        'message' => "",
        // array contendo os resultados mais informações adicionais
        'content' => []
    ];

    /**
     * Template para corpo da mensagem padrão para conteúdo das respostas
     *
     * @var array
     */
    public static $arr_message_content_pattern = [
        // labels para serem utilizados no front-end
        'labels' => [],
        // total de resultados retornados
        'results' => 0,
        // total de resultados dentro do critério
        'page' => 0,
        // array contendo todas as informações retornadas
        'data' => []
    ];

    /**
     * Formata uma resposta JSON e muda os headers da página
     *
     * @see Utils::$arr_message_pattern
     * @see Utils::$arr_message_content_pattern
     *
     * @param  array  $arr_data Contém todas as informações para serem retornadas
     * @return string Array para String em formato JSON
     */
    public static function response(array $arr_data): string
    {
        // limpa os headers
        header_remove();
        // injeta o código de retorno atual
        http_response_code($arr_data['status'] ?? 200);
        // força o cache
        header("Cache-Control: no-transform, public, max-age=300, s-maxage=900");
        header('Content-type: application/json; charset=utf-8');

        return json_encode($arr_data);
    }

    /**
     * Valida as informações recebidas por post ou put, baseados no método e regras de validação (definidas no [Nome]Model)
     *
     * @param  string $str_method      post/get/put/delete
     * @param  array  $arr_data        Contém mensagem formatada (header e conteúdo)
     * @param  array  $arr_validations Contém as regras de validações para cada campo (@see Model\[Controller]Model)
     * @param  array  $arr_fields      Contém todos os campos visíveis do Model
     * @return array                   Vazio se não contiver erros de validação
     */
    public static function validate_post(string $str_method, array $arr_data, array $arr_validations, array $arr_fields): array
    {
        $ret = [];

        if (!empty($str_method) && count($arr_data) > 0 && count($arr_validations) > 0 && count($arr_fields) > 0) {

            $ret_tmp = [];

            $bol_error = false;

            foreach ($arr_fields as $key => $value) {

                // interrompe o loop caso tenha ocorrido algum erro de validação anterior
                if ($bol_error === true) {
                    break;
                }

                // valida a presença do ID quando se trata de uma atualização (método PUT)
                if ($str_method == 'put' && (!isset($arr_data['id']) || !is_numeric($arr_data['id']))) {
                    $ret_tmp[422] = 'ID field is mandatory';
                    break;
                }

                // itera sobre as regras de validação verificando se aplica a cada elemento do POST
                $arr_tmp = explode('|', $arr_validations[$key]);

                foreach ($arr_tmp as $val) {

                    // valida obrigatório
                    if ($val == 'mandatory' && (is_null($arr_data[$key]) || empty($arr_data[$key]))) {
                        $ret_tmp[422] = vsprintf('%s is mandatory', [$value]);
                        $bol_error = true;
                        break;
                    }
                    // valida numérico
                    if ($val == 'number' && !is_numeric($arr_data[$key])) {
                        $ret_tmp[422] = vsprintf('%s needs to have a numeric value', [$value]);
                        $bol_error = true;
                        break;
                    }
                    // valida tamanho máximo
                    if ($val[0] == ':' && strlen($arr_data[$key]) > (int)substr($val, 1))  {
                        $ret_tmp[422] = vsprintf('%s needs contain until %u characters',
                            [$value, (int)substr($val, 1)]);
                        $bol_error = true;
                        break;
                    }
                    // valida data
                    if ($val == 'date' && DateTime::createFromFormat('Y/m/d', $arr_data[$key]) === false) {
                        $ret_tmp[422] = vsprintf('Date have an invalid format, given %s', [$arr_data[$key]]);
                        $bol_error = true;
                        break;
                    }
                }
            }

            // se ocorreu algum erro assume a mensagem de retorno
            if (count($ret_tmp) > 0) {
                $ret = $ret_tmp;
            }
        }

        return $ret;
    }

}