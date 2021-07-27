<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIAUTH
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Fox-Dos-API-KEY');
        if ($header == "142536") {
            return $next($request);
        }else{
            return response()->json(['status' => false, 'message' => "Wrong API Key"]);
        }
        
    }
}
