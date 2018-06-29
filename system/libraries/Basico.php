<?php

#Controller criado para a adição de classes que serã utilizadas pelos vários módulos que irão compor o SISHUAP

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico {

    public function __construct() {
        #error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        #define('WSPAC', 'http://200.20.7.198:4000/paciente/');
        #define('WSCENSO', 'http://200.20.7.198:4000/censo/');

        #define('WSPAC', 'http://10.10.20.91:4000/paciente/');
        #define('WSCENSO', 'http://10.10.20.91:4000/censo/');

        $modulo = explode('/', $_SERVER['REQUEST_URI']);
        define('MODULOBASEURL', $modulo[0] . '/' . $modulo[1] . '/' . $modulo[2] . '/');

    }

    public function gerar_select($opcoes, $valores) {

        $array = array();

        $opcoes = explode('|', $opcoes);
        $valores = explode('|', $valores);

        for($i=0; $i<count($opcoes); $i++)
            $array[$valores[$i]] = $opcoes[$i];

        return $array;
    }

    //converte valores decimais no formato mysql ou no formato BRL, retornando NULL caso a variável venha vazia.
    function revisao_campos($data) {

        foreach ($data as $key => $value) {
            if(!$value) {
                $data[$key] = NULL;
                #echo '<br />'.$key.' <> '.$value;
            }
            #echo '<br />'.$key.' <> '.$value;
        }
        /*
        print "<pre>";
        print_r($data);
        print "</pre>";
        exit('oi');
        */
        return $data;

    }


    //converte valores decimais no formato mysql ou no formato BRL, retornando NULL caso a variável venha vazia.
    function mascara_valor($data, $formato) {

        if(!$data)
            return NULL;
        else
            return ($formato == 'mysql') ? str_replace(',', '.', str_replace('.', '', $data)) : number_format($data, 2, ',', '.');

    }

    //se o código for codificado em iso-8859-1
    function multiple_selected($data){
        if($data) {
            foreach ($data as $key)
                $row[$key] = 1;
            return $row;
        }
        else
            return FALSE;
    }

    //se o código for codificado em iso-8859-1
    function remove_acentuacao($data){
        return strtr(
            $data,
            'àáâãäçèéêëìíîïñòóôõöùúûüıÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜİ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }

    //se o código for codificado em utf-8
    function remove_acentuacao_utf8($data) {
        return strtr(
            utf8_decode($data),
                utf8_decode(
                    'àáâãäçèéêëìíîïñòóôõöùúûüıÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜİ'),
                    'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }


    #create an alert like form_validator

    public function msg($msg, $tipo, $align = FALSE, $icon = FALSE, $modal = FALSE) {

        if ($tipo == 'erro') {
            $glyphicon = 'remove';
            $alert = 'danger';
        }
        elseif ($tipo == 'sucesso') {
            $glyphicon = 'ok';
            $alert = 'success';
        }
        elseif ($tipo == 'alerta') {
            $glyphicon = 'exclamation';
            $alert = 'warning';
        }
        else {
            $glyphicon = 'info';
            $alert = 'info';
        }

        if ($tipo == 'erro')
            $hide = 'hidediverro';
        else
            $hide = 'hidediv';


        $span = '';
        if ($icon === TRUE)
            $span = '<span class="glyphicon glyphicon-' . $glyphicon . '-sign"></span> ';

        if ($align === TRUE)
            $align = ' text-center';
        else
            $align = '';

        if ($modal === TRUE) {
            $data = '<div class="alert alert-' . $alert . ' hidediv text-center" id="' . $hide . '" role="alert">' . $span . $msg . '</div>';
        }
        else {
            $data = '
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="alert alert-' . $alert . $align . '" role="alert">' . $span . $msg . '</div>
                    </div>
                    <div class="col-md-2"></div>
                </div>';
        }

        return $data;

    }

    function check_date($data) {

        if ($data) {
            #if ($data && preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.]\d\d\d\d$/", $data)) {
            if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data) &&
                    checkdate(substr($data, 3, 2), substr($data, 0, 2), substr($data, 6, 4)))
                return TRUE;
            else
                return FALSE;
        } else {
            return TRUE;
        }

    }

    function calcula_idade($data) {

        $from = new DateTime($data);
        $to = new DateTime('today');
        return $from->diff($to)->y;

    }

    function get_sexo($data) {

        if ($data == 'M')
            return 'MASCULINO';
        elseif ($data == 'F')
            return 'FEMININO';
        else
            return NULL;

    }

    function get_nacionalidade($data) {

        if ($data == 'B')
            return 'BRASILEIRA';
        elseif ($data == 'E')
            return 'ESTRANGEIRA';
        else
            return NULL;

    }

    function set_log($anterior = NULL, $atual, $campos, $id, $update = NULL, $delete = NULL) {

        $query = array();

        $i = 0;
        #compara valores antigos com os novos e vê onde há mudanças
        if ($update === TRUE) {
            foreach ($campos as $novo) {
                #if ($atual[$novo] && $anterior[$novo] && $atual[$novo] != $anterior[$novo]) {
                if (isset($atual[$novo]) && isset($anterior[$novo]) && $atual[$novo] != $anterior[$novo]) {
                #if ($atual[$novo] != $anterior[$novo]) {
                    $query[] = array(
                        'Coluna' => $novo,
                        'ValorAnterior' => $anterior[$novo],
                        'ValorAtual' => $atual[$novo],
                        'ChavePrimaria' => $id,
                    );
                }
            }
        }
        #apenas monta o select para inserção de novos dados, sem fazer comparações
        else {
            if ($delete === TRUE) {
                foreach ($campos as $novo) {
                    if ($anterior[$novo]) {
                        $query[] = array(
                            'Coluna' => $novo,
                            'ValorAnterior' => $anterior[$novo],
                            'ChavePrimaria' => $id,
                        );
                    }
                }
            }
            else {
                foreach ($campos as $novo) {
                    if ($atual[$novo]) {
                        $query[] = array(
                            'Coluna' => $novo,
                            'ValorAtual' => $atual[$novo],
                            'ChavePrimaria' => $id,
                        );
                    }
                }
            }
        }

        /*
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

        return ($query) ? $query : FALSE;

    }

    function mascara_cpf($data, $completo = FALSE) {

        $zeros = 11 - strlen($data);
        for ($i = 0; $i < $zeros; $i++) {
            $data = '0' . $data;
        }

        if ($completo === FALSE) {
            return $data;
        }
        else {
            return substr($data, 0, 3) . '.' . substr($data, 3, 3) . '.' . substr($data, 6, 3) . '-' . substr($data, 9, 2);
        }

    }

    function mascara_cep($data, $completo = FALSE) {

        $zeros = 8 - strlen($data);
        for ($i = 0; $i < $zeros; $i++) {
            $data = '0' . $data;
        }

        if ($completo === FALSE) {
            return $data;
        }
        else {
            return substr($data, 0, 5) . '-' . substr($data, 5, 3);
        }

    }

    function mascara_data($data, $opcao, $hora = FALSE, $invertido = FALSE) {

        if(!$data)
            return NULL;

        //if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
        $pm = preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data);

        if ($opcao == 'barras') {
            if ($pm && $data && $data != '0000-00-00') {
                $data = nice_date($data, 'd/m/Y');
            }
            else {
                $data = '';
            }
        }
        elseif ($opcao == 'mysql') {

            if ($invertido) {
                if ($data > 18000000) {
                    //echo 'oi'.$data.'pp';
                    $data = DateTime::createFromFormat('Ymd', $data);
                    $data = $data->format('Y-m-d');
                }
                else {
                    //$data = NULL;
                    $data = '0000-00-00';
                }
            }
            else {
                if ($pm && $data) {
                    //echo 'oi'.$data.'pp';
                    $data = DateTime::createFromFormat('d/m/Y', $data);
                    $data = $data->format('Y-m-d');
                }
                else {
                    //$data = NULL;
                    $data = '0000-00-00';
                }
            }

        }
        elseif ($opcao == 'inverter') {
            if ($pm && $data) {
                $info = explode(" ", $data);
                $data = DateTime::createFromFormat('d-m-Y', $info[0]);
                $data = $data->format('Y-m-d');

                if ($hora)
                    $data = $data . ' ' . $info[1];
            }
            else {
                $data = NULL;
            }
        }
        //}

        return $data;

    }

    function mascara_prontuario($data) {

        $p = str_split(str_pad($data, 6, "0", STR_PAD_LEFT), 2);
        return $p[0] . '.' . $p[1] . '.' . $p[2];

    }

    function apenas_numeros($data) {

        return preg_replace("/[^0-9]/", "", $data);

    }

    function limpa_nome_arquivo($data) {
        return preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "_", $data);

    }

    function renomeia_arquivo($data, $path) {
        #$data = preg_replace("/\.[a-z]{1,9}/", "-copia$0", $data);
        #$data = "img01_2a_.pdf";
        #echo '<br>=> ' . $data;

        $pos2 = strrpos($data, "_.");
        $subs = substr($data, 0, $pos2);
        $pos1 = strrpos($subs, "_");
        $i = substr($subs, $pos1 + 1);

        #echo '<br>0 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;

        if (is_numeric($i))
            $data = substr($data, 0, $pos1) . '_' . ($i + 1) . substr($data, $pos2);
        else
            $data = preg_replace("/\.[a-z]{1,9}$/", "_1_$0", $data);

        #echo '<br>1 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;

        if (file_exists($path . $data)) {
            #echo '<br>oi - ' . $data;
            $data = $this->renomeia_arquivo($data, $path);
        }

        #echo '<br>2 - ' . $data;
        #echo '<br>path - ' . $path . ' ' . $data;
        #exit();

        return $data;

    }

    /*
    Função que converte abreviações em palavras completas
    */
    function mascara_abrev_completo($data, $abrev, $completo) {

        $abrev = explode('|', $abrev);
        $completo = explode('|', $completo);

        for($i=0; $i<=count($abrev); $i++)
            if (isset($abrev[$i]) && $abrev[$i] == $data) return $completo[$i];
        //return "NULL";
        return "";

    }

    function mascara_sim_nao($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'S')
                return 'SIM';
            if ($data == 'N')
                return 'NÃO';
            return "NULL";
        }
        else {

            if ($data == 'SIM')
                return 'S';
            if ($data == 'NÃO')
                return 'N';
            return "NULL";
        }

    }

    function mascara_esq_dir($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'E')
                return 'Esquerda';
            if ($data == 'D')
                return 'Direita';
            return "NULL";
        }
        else {

            if ($data == 'Esquerda')
                return 'E';
            if ($data == 'Direita')
                return 'D';
            return "NULL";
        }

    }

    function mascara_shave_discoide($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'S')
                return 'Shave';
            if ($data == 'D')
                return 'Discóide';
            return "NULL";
        }
        else {

            if ($data == 'Shave')
                return 'S';
            if ($data == 'Discóide')
                return 'D';
            return "NULL";
        }

    }

    function mascara_reg_irreg($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'R')
                return 'Regular';
            if ($data == 'I')
                return 'Irregular';
            return "NULL";
        }
        else {

            if ($data == 'Regular')
                return 'R';
            if ($data == 'Irregular')
                return 'I';
            return "NULL";
        }

    }

    function mascara_normal_anormal($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'N')
                return 'Normal';
            if ($data == 'A')
                return 'Anormal';
            return "NULL";
        }
        else {

            if ($data == 'Normal')
                return 'N';
            if ($data == 'Anormal')
                return 'A';
            return "NULL";
        }

    }

    function mascara_amb($data, $opcao = FALSE) {

        if ($opcao == 'completo') {

            if ($data == 'A')
                return 'Alto';
            if ($data == 'M')
                return 'Médio';
            if ($data == 'B')
                return 'Baixo';
            return "NULL";
        }
        else {

            if ($data == 'Alto')
                return 'A';
            if ($data == 'Médio')
                return 'M';
            if ($data == 'Baixo')
                return 'B';
            return "NULL";
        }

    }

    function aspas($data) {

        //echo " ==> ".$data." <== ";

        if (!$data)
            return "NULL";
        elseif ($data == "NULL")
            return "NULL";
        elseif ($data == "NI")
            return "NULL";
        elseif (is_numeric($data))
            return $data;
        elseif (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data))
            return '"' . $data . '"';
        else
            return '"' . str_replace("'", "\'", str_replace('"', '\"', $data)) . '"';
            #return '"' . $data . '"';

    }

    function radio_checked($data, $campo, $tipo = FALSE, $default = FALSE, $multi = FALSE, $array = FALSE) {

        $radio = FALSE;

        if (!$data && $default)
            $data = $default;

        if ($multi) {
            $tipo = explode('|', $tipo);
            $i = count($tipo);
        }
        else {
            $tipo = str_split($tipo);
            $i = count($tipo);
        }

        if ($array) {
            for ($j = 0; $j < $i; $j++) {

                if ($data == $tipo[$j]) {

                    for ($k = 0; $k < $i; $k++)
                        if ($k == $j) {
                            $radio['c'][$k] = 'checked';
                            $radio['a'][$k] = 'active';
                        }
                        else {
                            $radio['c'][$k] = '';
                            $radio['a'][$k] = '';
                        }

                }
            }
        }
        else {
            for ($j = 0; $j < $i; $j++) {

                if ($data == $tipo[$j]) {

                    for ($k = 0; $k < $i; $k++)
                        ($k == $j) ? $radio[$k] = 'checked' : $radio[$k] = '';

                }
            }
        }

        /*
        print "<pre>";
        print_r($radio);
        print "</pre>";
        #exit();
        */

        return $radio;

    }

    function checkbox_checked($data, $campo, $tipo = NULL, $default = NULL) {

        if ($data) {

            $tipo = str_split($tipo);

            for ($i = 0; $i < count($tipo); $i++)
                (isset($data[$i])) ? $checkbox[$i] = 'checked' : $checkbox[$i] = '';

            return $checkbox[0];
        }
        else {
            return FALSE;
        }

    }

    function div_showhide($data, $campo = FALSE, $valor = FALSE, $checkbox = FALSE, $default = FALSE, $todos = FALSE) {

        if ($todos == 1)
            return ($data != 0) ? '' : 'style="display: none;"';
        else {
            if ($checkbox)
                return ($data) ? '' : 'style="display: none;"';
            else {
                if($default && !$data)
                    return '';
                else
                    return ($data == $valor) ? '' : 'style="display: none;"';
            }
        }

    }

    function radio_button_background_color($valor, $opt, $bgcopt, $bgcdefault) {

        $opt = explode('|', $opt);
        $bgcopt = explode('|', $bgcopt);

        for ($i=0; $i < count($opt); $i++) {

            if ($valor == $opt[$i])
                $radio[$i] = $bgcopt[$i];
            else
                $radio[$i] = $bgcdefault;

        }

        return $radio;

    }

    function checkbox_value_converter($valor) {
        return ($valor == 'on') ? 1 : 0;
    }

    function checkbox_text_field_converter($pai, $filho, $opt = FALSE) {

        if($opt)
            return ($pai == $opt) ? $filho : NULL;
        else
            return ($pai == 1) ? $filho : NULL;
    }

    function gera_status_paciente($tpatendimento, $dtalta) {

        if ($dtalta != NULL) {
            $status['cor'] = 'success';
            $status['fa'] = 'home';
            $status['Situacao'] = 'Alta';
        }
        else {

            if ($tpatendimento == "I") {
                $status['cor'] = 'warning';
                $status['fa'] = 'bed';
                $status['Situacao'] = 'Internado';
            }
            elseif ($tpatendimento == "A") {
                $status['cor'] = 'info';
                $status['fa'] = 'stethoscope';
                $status['Situacao'] = 'Ambulatório';
            }
            elseif ($tpatendimento == "U") {
                $status['cor'] = 'danger';
                $status['fa'] = 'ambulance';
                $status['Situacao'] = 'Urgência';
            }
            elseif ($tpatendimento == "E") {
                $status['cor'] = 'primary';
                $status['fa'] = 'mail-forward';
                $status['Situacao'] = 'Encaminhamento';
            }
            else {
                $status['cor'] = 'secondary';
                $status['fa'] = 'question-circle';
                $status['Situacao'] = 'Status Desconhecido';
            }

        }

        return $status;

    }

    function substitui_valores($valor, $anterior, $atual) {

        $x = explode('|', $anterior);
        $y = explode('|', $atual);

        (count($x) != count($y)) ? exit('DIMENSÕES DIFERENTES') : FALSE;

        $z=array();
        for ($i=0; $i<count($x); $i++)
            $z[$x[$i]] = $y[$i];

        return (isset($z[$valor])) ? $z[$valor] : $valor;

    }

}
