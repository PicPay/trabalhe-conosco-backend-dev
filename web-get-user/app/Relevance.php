<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relevance extends Model
{
    public function getRelevance1() {
        $ids = array();
        $file_n = public_path() . '/lista_relevancia_1.txt';
        if (file_exists($file_n)) {
            $file = fopen($file_n, "r");
            while(($data = fgetcsv($file, 200, "\n")) !== FALSE) {
                $ids[] = $data[0];
            }

            fclose($file);
        }

        return $ids;
    }

    public function getRelevance2() {
        $ids = array();
        $file_n = public_path() . '/lista_relevancia_2.txt';
        if (file_exists($file_n)) {
            $file = fopen($file_n, "r");
            while(($data = fgetcsv($file, 200, "\n")) !== FALSE) {
                $ids[] = $data[0];
            }

            fclose($file);
        }

        return $ids;
    }
}
