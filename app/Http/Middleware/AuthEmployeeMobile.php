<?php

namespace App\Http\Middleware;

use App\Helpers\TokenHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthEmployeeMobile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $employee = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        if (!$employee) {
            return response()->json([
                'code' => 401,
                'msg' => 'User Token not valid'
            ], 401);
        } else {

            if ($employee->expired_at > time()) {
                return $next($request);
            } else {
                return response()->json([
                    'code' => 401,
                    'msg' => 'User Token not valid'
                ], 401);
            }
        }
    }
}
