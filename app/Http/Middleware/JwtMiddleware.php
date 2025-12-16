<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = Auth::user();
            if (!$user) {
                $this->error([], "User not found", 404);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                $this->error($e, "Token is invalid", 401);
            } elseif ($e instanceof TokenExpiredException) {
                $this->error($e, "Token expired", 401);
            } else {
                $this->error($e, "Authorization Token not found", 401);
            }
        }
        return $next($request);
    }
}
