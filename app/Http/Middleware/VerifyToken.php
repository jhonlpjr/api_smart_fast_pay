<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use app\modules\user\infraestructure\database\models\TokenModel;

class VerifyToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $token = $matches[1];

        if (!$token || !TokenModel::where('token', $token)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}