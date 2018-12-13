<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SistemaRepository;

class SistemaController extends Controller
{	

	protected $sistemaRepository;

	public function __construct(SistemaRepository $sistemaRepository)
    {
        $this->middleware('auth');
        $this->sistemaRepository = $sistemaRepository;
    }

    public function search($param)
    {
    	return $this->sistemaRepository->search($param);
    }
}
