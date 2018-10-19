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
        $data['page'] = (isset($input['page']) and is_integer($input['page'])?$input['page']:1);
        if(isset($input['search'])) {
            $clients = Clients::select('ident', 'name', 'user')->orderBy('name')
                ->where('name', 'like', '%' . $input['search'] . '%')->orWhere('user', 'like', '%' . $input['search'] . '%')
                ->paginate(15);

            $data['search'] = $input['search'];
        }
        else
            $clients = Clients::select('ident','name','user')->where('relevance','1')->orderBy('name')->paginate(15);

        $data['clients'] = $clients;

        return view('home',$data);
    }
}
