<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class DbReady extends Controller
{
    public function check(){
        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $content = file_get_contents($importFileStatusPath);
        return (new Response($content, 200))->header('Content-Type', "application/json");
    }
}
