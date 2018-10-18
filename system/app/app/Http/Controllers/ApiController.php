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
        if(isset($input['search'])) {
            $clients = Clients::select('ident', 'name', 'user')->orderBy('name')
                ->where('name', 'like', '%' . $input['search'] . '%')->orWhere('user', 'like', '%' . $input['search'] . '%')
                ->paginate(15);

            $data['search'] = $input['search'];
        }
        else
            $clients = Clients::select('ident','name','user')->orderBy('name')->paginate(15);

        $clients = json_decode(json_encode($clients), true);


        $data['total'] = $clients["total"];
        $data['current_page'] = $clients['current_page'];
        $data['last_page'] = $clients['last_page'];
        $data['clients'] = $clients['data'];

        return json_encode($data);
    }
}
