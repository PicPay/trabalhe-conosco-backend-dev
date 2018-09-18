<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\User;
use GuzzleHttp\Client;

class UserController extends Controller
{
    //
    public function index(Request $request, User $user){        

        $users = $user->offset(0)->limit(15)->get();
        return response()->json($users);
    }

    public function search(Request $request, User $user){
       
        if($request->nome)
            return $this->SearchNome($request->nome,$user);
        if($request->username)
            return $this->SearchUsername($request->username,$user);

        $users = $user->offset(0)->limit(15)->get();

        return response()->json($users);
        
    }

    public function SearchNome($nome, $user){
        
        $list1 = $user->join('list1','users.id','=','list1.id')->select('list1.id', 'users.id', 'nome', 'username')->where('nome', 'like', $nome.'%')->offset(0)->limit(15)->orderBy('list1.id', 'DESC')->get();
        if (count($list1)>0){
            $lista1 = $user->leftJoin('list1','users.id','=','list1.id')->select('list1.id', 'users.id', 'nome', 'username')->where('nome', 'like', $nome.'%')->offset(0)->limit(15)->orderBy('list1.id', 'DESC')->get();
            return response()->json($lista1);
        }
        
        $list2 = $user->join('list2','users.id','=','list2.id')->select('list2.id', 'users.id', 'nome', 'username')->where('nome', 'like', $nome.'%')->offset(0)->limit(15)->orderBy('list2.id', 'DESC')->get();    
        if (count($list2)>0){
            $lista2 = $user->leftJoin('list2','users.id','=','list2.id')->select('list2.id', 'users.id', 'nome', 'username')->where('nome', 'like', $nome.'%')->offset(0)->limit(15)->orderBy('list2.id', 'DESC')->get();
            return response()->json($lista2);
        }

        $users = $user->where('nome', 'like', $nome.'%')->offset(0)->limit(15)->orderBy('id','DESC')->get();
        return response()->json($users);
    }

    public function SearchUsername($username, $user){
        $list1 = $user->join('list1','users.id','=','list1.id')->select('list1.id', 'users.id', 'nome', 'username')->where('username', 'like', $username.'%')->offset(0)->limit(15)->orderBy('list1.id', 'DESC')->get();
        if (count($list1)>0){
            $lista1 = $user->leftJoin('list1','users.id','=','list1.id')->select('list1.id', 'users.id', 'nome', 'username')->where('username', 'like', $username.'%')->offset(0)->limit(15)->orderBy('list1.id', 'DESC')->get();
            return response()->json($lista1);
        }
        
        $list2 = $user->join('list2','users.id','=','list2.id')->select('list2.id', 'users.id', 'nome', 'username')->where('username', 'like', $username.'%')->offset(0)->limit(15)->orderBy('list2.id', 'DESC')->get();    
        if (count($list2)>0){
            $lista2 = $user->leftJoin('list2','users.id','=','list2.id')->select('list2.id', 'users.id', 'nome', 'username')->where('username', 'like', $username.'%')->offset(0)->limit(15)->orderBy('list2.id', 'DESC')->get();
            return response()->json($lista2);
        }

        $users = $user->where('username', 'like', $username.'%')->offset(0)->limit(15)->orderBy('id','DESC')->get();
        return response()->json($users);
    }

    public function indexView(Request $request, User $user){
        $http = new Client;
        if($request->nome){
            $request = $http->get('http://192.168.1.4/api/user/search?nome='.$request->nome);
        }else{
            $request = $http->get('http://192.168.1.4/api/user/');
        }
        $response = json_decode((string) $request->getBody(), true);
        return view('search', compact('response',$response));
    }

    
}
