<?php

namespace App\Http\Middleware;

use Closure;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('Authorization') != null) {
            $header = $request->header('Authorization');
            $token = 'ZWx1c3VhcmlvOnlsYWNsYXZl';
            if($header == 'Basic ' . $token) {
                return $next($request);
            }
        }

        $status = ['status' => 'Requer autorização para recuperar os dados.'];
        
        return response()->json($status);
    }
}
