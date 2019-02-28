<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Basemkhirat\Elasticsearch\Connection;

class InsertDataSampleToElasticsearch extends Seeder
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
        $this->table = 'users';
        $this->filename = database_path('DataSeed/users.csv');

        $this->connection = Connection::create([
            'servers' => [
                [
                    "host" => "127.0.0.1",
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
        DB::connection('mysql2')->table('users')
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'usr_relevance_list.relevance'
            )
            ->leftJoin('usr_relevance_list', 'users.id', '=', 'usr_relevance_list.id')
            ->orderByRaw("CASE WHEN usr_relevance_list.relevance is null then 1 else 0 end")
            ->chunk(5000, function($users) {
                foreach ($users as $user)
                {
                    echo "Indexando no ElaticSearch.: ";
                    dump($user);
                    $this->connection->type('users')->insert($user);
                }
        });
    }
}
