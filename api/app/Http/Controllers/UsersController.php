<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\UsersService;

class UsersController extends Controller
{
    public function get(Request $request, UsersService $us)
    {
        //from é o offset da busca (paginacao)
        $from = 0;
        $keyword = null;

        if ($request->has("from")) {
            $from = $request->input('from');
        }

        //A palavra chave esta sendo passada no "name"
        if ($request->has("name")) {
            $keyword = $request->input('name');
        }

        $return = $us->get($keyword, $from);

        return (new Response(json_encode($return), 200))->header('Content-Type', "application/json");
    }
}
