<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class CheckElasticSearchStatusController extends Controller
{
    public function check(){
        //le o arquivo q informa se a importação do csv está sendo executada
        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $content = file_get_contents($importFileStatusPath);
        return (new Response($content, 200))->header('Content-Type', "application/json");
    }
}
