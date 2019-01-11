<?php

use Illuminate\Database\Seeder;
use App\Relevancia;

class RelevanciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('relevancias')->delete();

        foreach (explode(PHP_EOL,file_get_contents(database_path('DataSeed/lista_relevancia_1.txt'))) as $id_hash) {
            if($id_hash)
            {
                Relevancia::create([
                    'id_hash' => $id_hash,
                    'relevancia' => 1
                ]);

                $this->command->info($id_hash . ' Importado!');
            }
        }

        foreach (explode(PHP_EOL,file_get_contents(database_path('DataSeed/lista_relevancia_2.txt'))) as $id_hash) {
            if($id_hash)
            {
                Relevancia::create([
                    'id_hash' => $id_hash,
                    'relevancia' => 2
                ]);

                $this->command->info($id_hash . ' Importado!');
            }
        }
    }
}
