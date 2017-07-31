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

        // verifico se existe uma index de fulltext no banco
        // se não existir, é porque o processo de migração de dados ainda não terminou
        $exists = DB::select("show index from contacts  where Index_type = 'FULLTEXT'");
        if(!$exists) return response()->json(['aguarde conclusão da migração de dados'], 422, array(), JSON_PRETTY_PRINT);

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