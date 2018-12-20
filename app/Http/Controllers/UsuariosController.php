<?php

namespace App\Http\Controllers;

use App\Usuarios;
use Basemkhirat\Elasticsearch\Facades\ES;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UsuariosController extends Controller{

    private function execute($commad){

        $process = new Process($commad);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput() ;
    }

    // daqui pra baixo são exemplos

    public function index()
    {
        $usuarios = Usuarios::all()->take(20);
        return response()->json($usuarios);
    }

    public function getUserLimitOfset()
    {
        $usuarios = DB::table('usuarios')->simplePaginate(15);
        return response()->json($usuarios);
    }

    public function getUserSearch(Request $search)
    {
        $usuarios = ES::type("users")->search($search->get('q'))
            ->select(
                "id_controle",
                "name",
                "username",
                "relevancia"
            )
            ->orderBy("relevancia")
            ->paginate(15);

        return response()->json($usuarios);
    }

    public function getUserMysql(Request $search)
    {
        $usuarios = DB::table('usuarios')
            ->select(
                'usuarios.id_controle',
                'name',
                'username',
                'relevancia'
            )
            ->where('name', 'like', '%' . $search->get('q') . '%')
            ->orWhere('username', 'like', '%' . $search->get('q') . '%')
            ->orderByRaw("CASE WHEN relevancia is null then 1 else 0 end")
            ->simplePaginate(15);
        return response()->json($usuarios);
    }

    public function getUser($id)
    {
        $usuarios  = Usuarios::find($id);
        return response()->json($usuarios);
    }

    public function createUser(Request $request)
    {
        $usuarios = Usuarios::create($request->all());
        return response()->json($usuarios);
    }

    public function deleteUser($id)
    {
        $usuarios  = Usuarios::find($id);
        $usuarios->delete();
        return response()->json('deleted');
    }

    public function updateUser(Request $request,$id)
    {
        $usuarios  = Usuarios::find($id);
        $usuarios->name = $request->input('name');
        $usuarios->username = $request->input('username');
        $usuarios->save();

        return response()->json($usuarios);
    }

}
?>