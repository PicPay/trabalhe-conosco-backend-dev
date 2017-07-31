<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiLoginController extends Controller
{
    // method 1
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    // method 2
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // usuario
            $user = Auth::user();

            // pego o token a partir do usuário criado
            $token = $this->retorna_token_from_user($user);

            // retorno o token
            return $this->saida($token, $user);
        } else {
            $saida = ['errors' => ['user_or_password_incorrect']];
            return response()->json($saida, 422, array(), JSON_PRETTY_PRINT);
        }
    }

    // header Authorization: Bearer {token}
    public function refresh(Request $request)
    {
        $token = JWTAuth::getToken();
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json(compact('token'));
        //return $this->saida($newToken);
    }

    public function logout(Request $request)
    {
        // invalido o token
        try {
            // capto o token e o usuario
            $token = JWTAuth::getToken();
            if($token) {
                JWTAuth::setToken($token)->invalidate();
            }
        }
        catch (TokenBlacklistedException $e) {

        }

        return ['ok'];
    }

    private function retorna_token_from_user($user)
    {
        // attempt to verify the credentials and create a token for the user
        if (! $token = JWTAuth::fromUser($user)) {
            return response()->json(['errors' => ['invalid_credentials']], 401);
        }

        return $token;
    }

    private function saida($token, User $user=null)
    {
        $objectToken = JWTAuth::setToken($token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');
        $saida = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'expires_in_pt_br' => Carbon::createFromTimestamp($expiration),
        ];

        return response()->json($saida, 200, [], JSON_PRETTY_PRINT);
    }

}