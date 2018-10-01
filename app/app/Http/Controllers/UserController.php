<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected $service;

  public function __construct(UserService $service){
    $this->service = $service;
  }

  public function index(Request $request)
  {
    return (new UserCollection($this->service->getUsersPaginated($request->get('q'))))
      ->response();
  }

  public function prioritize(Request $request)
  {
    $this->service->prioritizeUsers();
  }
}

