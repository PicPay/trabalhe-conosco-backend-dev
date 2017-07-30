<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Support\Facades\DB;

//use Sleimanx2\Plastic\Facades\Plastic;

class TesteController extends Controller
{
    public function index()
    {
        //$registros = Contact::limit(100)->get();
        //Plastic::persist()->bulkSave($registros);

        //$registros->searchable();

        //$registros = Contact::search('joao')->get();
        //dd($registros);

        //$path = storage_path('app/file.txt');
        //return $path;

        $query = "
            LOAD DATA LOCAL INFILE '/var/www/src/storage/lista_relevancia_1.txt'
            INTO TABLE imports 
            FIELDS TERMINATED by ',' 
            LINES TERMINATED BY '\n'
        ";

        DB::connection()->getpdo()->exec($query);

        return DB::table('imports')->select(['id'])->get();


        return ['ok'];


    }
}
