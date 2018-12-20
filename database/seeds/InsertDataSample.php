<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Basemkhirat\Elasticsearch\Connection;

class InsertDataSample extends Seeder
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


    protected $connection;

    public function __construct()
    {
        $this->table = 'usuarios';
        $this->filename = database_path('DataSeed/users.csv');

        $this->connection = Connection::create([
            'servers' => [
                [
                    "host" => env("ELASTIC_HOST", "127.0.0.1"),
                    "port" => env("ELASTIC_PORT", 9200),
                    'user' => env('ELASTIC_USER', ''),
                    'pass' => env('ELASTIC_PASS', ''),
                    'scheme' => env('ELASTIC_SCHEME', 'http'),
                ]
            ],
            'index' => 'my_index'
        ]);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table($this->table)->delete();

        $header = array('id_controle', 'name', 'username', 'created_at', 'relevancia');

        if (($handle = fopen($this->filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $row[] = Carbon::now()->format('Y-m-d H:i:s');

                $relevancia = DB::connection('mysql2')->table('lista_relevancia')->select('relevancia')
                    ->where('id_controle', '=', $row[0])
                    ->get();

                $row[] = ($relevancia->count() > 0) ? $relevancia[0]->relevancia : null;

                $rowCombine = array_combine($header, $row);

                $this->connection->type('users')->insert($rowCombine);

                DB::connection('mysql2')->table($this->table)->insert($rowCombine);

            }
            fclose($handle);
        }
    }
}
