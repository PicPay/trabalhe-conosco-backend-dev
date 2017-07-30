<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiSearchController extends Controller
{
    public function search(Request $request)
    {
        $key = $request->key;

        //$result = Contact::search($key)->orderBy('nome', 'desc')->paginate(15);
        //DB::connection()->enableQueryLog();
        $result = Contact::select(['contacts.id', 'contacts.token','contacts.nome','contacts.username'])
            ->leftJoin('suggestions', 'suggestions.token', 'contacts.token')
            ->whereRaw("MATCH (nome, username) AGAINST (? IN NATURAL LANGUAGE MODE)", [$key])
            ->orderByRaw("-suggestions.level desc")
            ->paginate(15);
            //->get();
        //return DB::getQueryLog();
        return response()->json(compact('result'));
    }
}