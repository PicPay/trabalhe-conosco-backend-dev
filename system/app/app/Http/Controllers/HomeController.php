<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $data['search'] = '';
        $page = 1;
        if(isset($input['page']) and is_numeric($input['page'])) $page = $input['page'];

        if(isset($input['search'])) {
            $clients = Clients::select('ident', 'name', 'user','relevance')
                ->where('name', 'like', '%' . $input['search'] . '%')->orWhere('user', 'like', '%' . $input['search'] . '%')
                ->orderBy('relevance','desc')
                ->skip(($page*15)-15)
                ->limit(15)
                ->get();

            $data['search'] = $input['search'];
        }
        else {
            $clients = Clients::select('ident', 'name', 'user', 'relevance')
                ->orderBy('relevance', 'desc')
                ->skip(($page * 15) - 15)
                ->limit(15)
                ->get();
        }

        $data['clients'] = $clients;
        $data['paginator']['currentPage'] = $page;
        $data['paginator']['url'] = '?search='.$data['search'].'&page=';


        return view('home',$data);
    }
}
