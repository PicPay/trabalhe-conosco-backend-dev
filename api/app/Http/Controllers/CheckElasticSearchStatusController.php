<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Variables;

class CheckElasticSearchStatusController extends Controller
{
    public function check(){
        //le o arquivo q informa se a importação do csv está sendo executada
        $esstatus = Variables::where('name', 'esstatus')->first();
        if($esstatus){
            $status = intval($esstatus->value);
            return (new Response(json_encode(array('status' => $status)), 200))->header('Content-Type', "application/json");
        }
        return new Response("", 500);

        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $content = file_get_contents($importFileStatusPath);
        return (new Response($content, 200))->header('Content-Type', "application/json");
    }
}
