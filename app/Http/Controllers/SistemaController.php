<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SistemaRepository;
use App\UsersPicpay;

class SistemaController extends Controller
{	

	protected $sistemaRepository;

	public function __construct(SistemaRepository $sistemaRepository)
    {
        $this->middleware('auth');
        $this->sistemaRepository = $sistemaRepository;
    }

    public function pesquisarTermo(Request $request)
    {
        $query = $request->query('query');
        $page = ($request->query('m') == 1) ? $request->query('page') : 1;
        $result = $this->sistemaRepository->search($query,$page); 
        $totalPaginas = ceil($result['total']/15);
        return view('home',[ "result" => $result, "page" => $page, "query" => $query, "totalPaginas" => $totalPaginas ]);
    }
}
