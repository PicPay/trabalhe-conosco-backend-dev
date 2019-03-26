<?php

require_once ROOT . '/App/Utils.php';

/**
 * Class Controller
 *
 * Recupera a rota pela URL inserida e encaminha para o controller correspondente [Rota]Controller
 *
 * @package App\
 * @see Controller\
 * @see Model\
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class Controller
{
    private $str_current_url = "";
    private $str_method = "";
    private $arr_url_path = [];
    private $str_controller_name = "";
    private $str_controller_path = "";
    private $str_class_name = "";
    private $arr_post = [];

    /**
     * Controller constructor.
     *
     * Insere as informações essenciais para a continuidade de fluxo do sistema
     */
    public function __construct()
    {
        // recupera a url digitada (/controller/id/limit/offset)
        $this->str_current_url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // recupera o método utilizado (GET, POST, PUT, DELETE)
        $this->str_method = strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));

        // recupera todas as variáveis do post (caso seja aplicável)
        if ($this->str_method == 'post') {
            $this->arr_post = filter_input_array(INPUT_POST);
        // recupera todas as variáveis do put (caso seja aplicável)
        } elseif ($this->str_method == 'put') {
            parse_str(file_get_contents("php://input"),$this->arr_post);
        }
    }

    /**
     * Trata o url de entrada e cria um array, sendo a primeira parte o controller e as demais,
     * as variáveis que serão passadas
     *
     * @return bool
     */
    private function generate_route_path(): bool
    {
        $ret = false;

        if (!empty($this->str_current_url)) {
            $arr_path = explode('/', $this->str_current_url);

            // acerta o array com o path completo, eliminando os valores vazios e reorganizando sua ordem (importante!)
            $arr_path = array_values(array_filter($arr_path, function ($element) { return rawurlencode($element) !== ""; }));

            // se o primeiro elemento não estiver vazio, foi inserido a url corretamente
            // (com o controller, ex.: /uf)
            if (!empty($arr_path[0])) {
                $this->arr_url_path = $arr_path;
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * Verifica se o arquivo de controller existe (posição 0 de $this->arr_url_path)
     *
     * @return bool
     */
    private function validate_controller(): bool
    {
        // recupera o nome do controller e transforma no padrão [Nome]Controller
        // -> primeira letra em maiúsculo e o restante da palavra em minúsculo
        $this->str_controller_name = ucfirst(strtolower($this->arr_url_path[0])) . 'Controller';
        // recupera o nome da classe para ser utilizada em cascata (Controller e Model)
        $this->str_class_name = ucfirst(strtolower($this->arr_url_path[0]));
        // gera o caminho completo para acesso ao arquivo de controller.
        $this->str_controller_path = ROOT . '/Controller/' . $this->str_controller_name . '.php';

        $ret = file_exists($this->str_controller_path);

        return $ret;
    }

    /**
     * Instancia objeto [URL]Controller dinamicamente e verifica se o método utilizado (POST, GET, ...) é permitido
     *
     * @return object null / [URL]Controller
     */
    private function validate_method(): object
    {
        $ret = null;

        require_once $this->str_controller_path;

        $obj_controller = new $this->str_controller_name($this->str_class_name);

        if (method_exists($obj_controller, $this->str_method)) {
            $ret = $obj_controller;
        }

        return $ret;
    }

    /**
     * Faz a execução do fluxo do processo:
     * Controller => [URL]Controller => BaseController => [URL]Model => BaseModel => Banco de dados
     *
     * @return string
     */
    public function run(): string
    {
        // recebe informações do model
        $arr_data = [];
        // lista de parâmetros para serem enviados ao controller
        $arr_params = [];
        $arr_message = Utils::$arr_message_pattern;

        try {
            // gera
            $bol_tmp_route = $this->generate_route_path();
            $bol_tmp_controller = $this->validate_controller();
            $obj_controller = $bol_tmp_route === true && $bol_tmp_controller === true ? $this->validate_method() : null;

            // verifica se foi inserido uma rota/alguma_coisa
            // se caso tenha sido inserido /alguma_coisa, valida se o controller existe
            // e se também depois disso se o método é permitido
            if ($bol_tmp_route === true && $bol_tmp_controller === true && !is_null($obj_controller)) {

                // verifica se foi um POST ou PUT e encaminha as variáveis recebidas por ele
                if ($this->str_method == 'post' || $this->str_method == 'put') {
                    $arr_params = $this->arr_post;
                } else {
                    // retira o nome do controller do array do path, restando só as variáveis que serão
                    // encaminhadas para o controller
                    unset($this->arr_url_path[0]);
                    $arr_params = array_values(isset($this->arr_url_path) ? $this->arr_url_path : []);
                }

                // recupera a resposta da chamada:
                //         ObjetoController->[get/post/put/delete]([parametros])
                $arr_data = $obj_controller->{$this->str_method}($arr_params);

                // verifica se o objeto contém alguma mensagem de erro
                if (count($obj_controller->return) > 0) {
                    $arr_message['status'] = key($obj_controller->return);
                    $arr_message['type'] = 'error';
                    $arr_message['message'] = $obj_controller->return[key($obj_controller->return)];

                } else {
                    // verifica se o método é permitido
                    if (is_array($arr_data) && count($arr_data) > 1) {

                        // verifica se a lista de resultados retornar vazia, registro não encontrado
                        if (count($arr_data['data']) == 0) {
                            $arr_message['status'] = 404;
                            $arr_message['type'] = 'error';
                            $arr_message['message'] = 'Not found';
                        // restorna o resultado completo quando tudo ok
                        } else {
                            $arr_message['status'] = 200;
                            $arr_message['type'] = 'success';
                            $arr_message['message'] = 'ok';
                            $arr_message['content'] = $arr_data;
                        }
                    // não é permitido o acesso ao método
                    } else {
                        $arr_message['status'] = 405;
                        $arr_message['type'] = 'error';
                        $arr_message['message'] = 'Method not allowed';
                    }
                }

            // senão retorna 404
            } else {
                $arr_message['status'] = 404;
                $arr_message['type'] = 'error';
                $arr_message['message'] = 'Not found';
            }

        } catch (Exception $e) {
            $arr_message['status'] = 500;
            $arr_message['type'] = 'error';
            $arr_message['message'] = $e->getMessage();
        } finally {
            return Utils::response($arr_message);
        }

    }
}