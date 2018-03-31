<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = "";
        $users = array();
        if(isset($request['keyword'])) {
            $keyword = $request['keyword'];
            if(strlen($keyword) < 3) {
                return Redirect::back()->withErrors(['A busca deve conter no mínimo 3 caracteres']);
            } else {
                set_time_limit(0);
                $token = 'ZWx1c3VhcmlvOnlsYWNsYXZl';
                $url = '/api/user/' . $keyword;
                $requestClient = Request::create($url, 'GET');
                $requestClient->headers->set('Content-Type', 'application/json');
                $requestClient->headers->set('Authorization', 'Basic ' . $token);
                $response = app()->handle($requestClient);
                $array = json_decode($response->getContent());
                if(isset($array->status)) {
                    return Redirect::back()->withErrors([$array->status]);
                } else {
                    $users = $array;
                }
            }
        }

        return Redirect::back()->with(['users' => $users, 'keyword' => $keyword]);
    }
}
