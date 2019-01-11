<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use App\Relevancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function index(Request $request)
    {
        //die($request->get('q'));

        if($request->get('q') && $request->get('q') != 'null' && $buscaInput = $request->get('q'))
        {
            $usuarios = DB::table('usuarios')->select(
                            'id',
                            'id_hash',
                            'nome',
                            'username',
                            'relevancia'
                        )
                        ->where('nome', 'LIKE','%'.$buscaInput.'%')
                        ->orwhere('username', 'LIKE','%'.$buscaInput.'%')
                        ->whereNull('deleted_at')
                        ->orderByRaw('ISNULL(relevancia), relevancia ASC')
                        ->orderBy('nome', 'ASC')
                        ->paginate(15);

        }
        else
        {
            $usuarios = DB::table('usuarios')
                        ->select(
                            'id',
                            'id_hash',
                            'nome',
                            'username',
                            'relevancia'
                        )
                        ->whereNull('deleted_at')
                        ->orderByRaw('ISNULL(relevancia), relevancia ASC')
                        ->orderBy('nome', 'ASC')
                        ->paginate(15);
        }

        // $usuarios = Usuarios::orderByRaw('ISNULL(relevancia), relevancia ASC')
        //                 ->orderBy('nome', 'ASC')
        //                 ->paginate(15);


        if(!$usuarios){
            return response()->json([
            'message' => 'Nenhum usuário cadastrado.',
            ],404);
        }
        return response()->json($usuarios);
    }

    public function show($id){

        $usuario = Usuarios::find($id);
        if(!$User){
           return response()->json([
              'message' => 'Usuário não encontrado.',
           ],404);
        }
        return response()->json($usuario);
     }

     public function store(Request $request)
     {
        $this->validate($request,[
            'username' => 'required|min:3',
            'nome' => 'required|min:3',
        ]);

        $usuario = new Usuarios();
        //$usuario->fill($request->all());
        $usuario->id_hash = md5($request->input('username').now());
        $usuario->nome = $request->input('nome');
        $usuario->username = $request->input('username');
        $usuario->relevancia = $request->input('relevancia');

        if($usuario->save())
        {
            return response()->json($usuario, 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar usuário',
         ], 404);

    }

    public function update(Request $request, $id)
    {
        $usuario = Usuarios::find($id);

        if(!$usuario) {
           return response()->json([
              'message' => 'Usuário não encontrado',
           ], 404);
        }

        //$usuario->fill($request->all());
        $usuario->id_hash = $request->get('id_hash');
        $usuario->nome = $request->get('nome');
        $usuario->username = $request->get('username');
        $usuario->relevancia = $request->get('relevancia');
        if($usuario->save())
        {
            return response()->json($usuario);
        }
        else
        {
            return response()->json([
                'message' => 'Erro ao salvar o usuário.',
             ],404);
        }


    }

    public function destroy($id)
    {
        $usuario = Usuarios::find($id);

        if(!$usuario) {
          return response()->json([
             'message' => 'Usuário não encontrado.',
          ], 404);
        }

        if($usuario->delete())
        {
            return response()->json([
                'message' => 'Usuário deletado',
             ], 200);
        }

        return response()->json([
            'message' => 'Erro ao excluir usuário.',
         ], 404);

    }

}
