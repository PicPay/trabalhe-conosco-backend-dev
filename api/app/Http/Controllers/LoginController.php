<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request){
        $email = $request->input('username');
        $password = $request->input('password');
        $user = User::where('email', trim($email))->first();
        if($user){
            if(password_verify($password, $user->password))    {
                $success['token'] = $user->createToken('Front')->accessToken;
                return response()->json(['success' => $success], 200);
            }else{
                return response()->json(['error'=>'Unauthorised'], 401);
            }
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
}
