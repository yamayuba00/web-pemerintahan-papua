<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EncryptApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $secretKey = env('API_ENCRYPT_KEY');
        $apiSecretKey = env('API_ENCRYPT_KEY_2');

        $clientKey = $request->header('X-Internal-Key');
        $clientKey2 = $request->header('X-APP-Key');

        if (!$clientKey || $clientKey !== $secretKey) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized Access: Private API only.',
            ], 403);
        }

        if (!$clientKey2 || $clientKey2 !== $apiSecretKey) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized Access: Private API only.',
            ], 403);
        }
        return $next($request);
    }
}
