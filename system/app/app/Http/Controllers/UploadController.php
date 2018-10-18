<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Clients;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    //

    public function index(){

        echo '<h1></h1><br><br>';

        // verifica se o arquivo csv já foi baixado

        if(!file_exists('../storage/app/users.csv')){
            $data['html'] = '<p>Arquivo não encontrado! Por favor, fazer o download do csv nesse link: https://s3.amazonaws.com/careers-picpay/users.csv.gz e descompactar o csv na pasta "system/app/storage/app/"</p>';
            return view('upload.index');
        }

        // abre o arquivo e executa linha por linha

        Artisan::call('migrate');

        Artisan::call('user:save');

        Artisan::call('save:csv');



        echo '<p>Criandos registros de clientes no banco!</p><br><br>';

    }
}
