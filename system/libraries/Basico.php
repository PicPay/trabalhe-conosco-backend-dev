<?php

#Controller criado para a adição de classes que serã utilizadas pelos vários módulos que irão compor o SISHUAP

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico {

    public function __construct() {

        $modulo = explode('/', $_SERVER['REQUEST_URI']);
        define('MODULOBASEURL', $modulo[0] . '/' . $modulo[1] . '/' . $modulo[2] . '/');

    }

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

}
