<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use GuzzleHttp\Client;


class UserController extends Controller
{
    //
    public function index(Request $request, User $user){        

        $users = $user->paginate(15);
        return response()->json($users);
    }

    public function search(Request $request, User $user){
        
            if($request->q)
                return $this->searchQ($request->q,$user,$request);
        
    }

    
    public function searchQ($q, $user,$request){
        
        $countlist1 = 0;
        $list1 = array();
        $list2 = array();
        $list1= $user
                ->join('list1','users.id','=','list1.id')
                ->select('users.id', 'nome', 'username')
                ->where('nome', 'like', $q.'%')
                ->orWhere('username', 'like', $q.'%')
                ->orderBy('list1.id', 'DESC')
                ->paginate(15);
        $countlist1 = count($list1);
        
        $list2 = $user
                ->leftJoin('list2','users.id','=','list2.id')
                ->select('users.id', 'nome', 'username')
                ->where('nome', 'like', $q.'%')
                ->orWhere('username', 'like', $q.'%')
                ->orderBy('list2.id', 'DESC')
                ->paginate(15-$countlist1);
        
        if($countlist1>0){
            $lista = array();
            foreach($list1 as $list){
                
                array_push($lista,$list);
                
            }
            foreach($list2 as $list){
                
                array_push($lista,$list);
                
            }
            $response = $lista;
            
        }else{
            $response = $list2;
        }
        
        return response()->json($response);
    }

    public function indexView(Request $request, User $user){
        $http = new Client;
        if($request->q){
            if($request->p){
                $r = $http->get($request->p.'&q='.$request->q);
            }else{
                $r = $http->get('http://192.168.1.4/api/user/search?q='.$request->q);
            }
            
        }else{
            if($request->p){
                $r = $http->get($request->p);
            }else{
                $r = $http->get('http://192.168.1.4/api/user/');
            }
            
        }
        $response = json_decode((string) $r->getBody(), true);
        $q = $request->q;
        $p = $request->p;
        return view('search', compact('response',$response,'q',$q,'p',$p));
    }

    
}
