<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
     $users = User::orderBy("id", "DESC")->paginate(100);
     return response()->json($users);
    }

    public function show($id)
    {
      $user = User::find($id);
      return response()->json($user);
    }

    public function search($query) {
      $results = User::where('username', 'like', "%{$query}%")
                      ->orWhere('name', 'like', "%{$query}%")
                      ->paginate(100);

      return response()->json($results);
    }

    //
}
