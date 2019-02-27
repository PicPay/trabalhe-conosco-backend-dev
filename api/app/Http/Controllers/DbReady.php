<?php

namespace App\Http\Controllers;

class DbReady extends Controller
{
    public function check(){
        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $content = file_get_contents($importFileStatusPath);
        echo $content;
    }
}
