<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //

    public function index(Request $request)
    {
        $input = $request->all();
        $data['search'] = '';
        $page = 1;
        if(isset($input['page']) and is_numeric($input['page'])) $page = $input['page'];

        if(isset($input['search'])) {
            $clients = Clients::select('ident', 'name', 'user','relevance')->orderBy('relevance','desc')
                ->where('name', 'like', '%' . $input['search'] . '%')->orWhere('user', 'like', '%' . $input['search'] . '%')
                ->skip(($page*15)-15)
                ->limit(15)
                ->get();

            $data['search'] = $input['search'];
        }
        else
            $clients = Clients::select('ident','name','user','relevance')->orderBy('relevance','desc')
                ->skip(($page*15)-15)
                ->limit(15)
                ->get();

        $clients = json_decode(json_encode($clients), true);

        return json_encode($clients);
    }
}
