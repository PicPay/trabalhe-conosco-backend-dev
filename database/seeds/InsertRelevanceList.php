<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertRelevanceList extends Seeder
{
    /**
     * DB table name
     *
     * @var string
     */
    protected $table;

    /**
     * CSV filename
     *
     * @var string
     */
    protected $filename;

    public function __construct()
    {
        $this->table = 'lista_relevancia';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table($this->table)->delete();

        foreach (explode(';',file_get_contents(database_path('DataSeed/lista_relevancia_1.txt'))) as $id_controle) {
                $data = array(
                    'id_controle' => $id_controle,
                    'relevancia' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                );

                DB::connection('mysql2')->table($this->table)->insert($data);
        }

        foreach (explode(';',file_get_contents(database_path('DataSeed/lista_relevancia_2.txt'))) as $id_controle2) {
            $data2 = array(
                'id_controle' => $id_controle2,
                'relevancia' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            );

            DB::connection('mysql2')->table($this->table)->insert($data2);
        }
    }
}
