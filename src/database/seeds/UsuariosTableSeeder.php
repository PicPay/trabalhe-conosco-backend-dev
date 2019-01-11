<?php

use Illuminate\Database\Seeder;
use App\Relevancia;
use App\Usuarios;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('usuarios')->delete();

        $startTime = now();
        if (($handle = fopen(database_path('DataSeed/users.csv'), 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                DB::table('usuarios')->insert([
                    'id_hash' => $row[0],
                    'nome' => $row[1],
                    'username' => $row[2],
                    'created_at' => now(),
                    'relevancia' => null
                ]);

                $this->command->info($row[1] . ' Importado!');
            }
            fclose($handle);
        }
        //Atualiza a relevancia....
        $relevancias = Relevancia::all();
        foreach($relevancias as $relevancia)
        {
            $usuario = Usuarios::where('id_hash', $relevancia->id_hash)->get();
            $usuario = $usuario->first();
            $usuario->relevancia = $relevancia->relevancia;
            $usuario->save();
        }
        $endTime = now();
        $this->command->info($startTime . ' Inicio');
        $this->command->info($endTime . ' Fim!');


    }
}
