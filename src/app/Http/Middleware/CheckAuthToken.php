<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\BearerToken;
use App\Models\LogPass;
use App\Models\TokenType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->bearerToken()) {
            $token = BearerToken::where('token', hash('sha256', $request->bearerToken()))->first();

            if ($token && $token->tokenable) {
                $tokenTypeId = $token->tokenable->token_type_id;
                $availableRoutes = TokenType::find($tokenTypeId)->first()->services->pluck('name')->toArray();
                $requestRoute = request()->route()->getName();
                if (in_array($requestRoute, $availableRoutes)) {
                    Auth::setUser($token->tokenable);
                    return $next($request);
                }
            }
        }
        if ($request->query('key') || $request->header('key')) {

            $apiKey = $request->query('key') ?: $request->header('key');
            $key = ApiKey::where('key', hash('sha256', $apiKey))->first();
            if ($key && $key->tokenable) {
                $tokenTypeId = $key->tokenable->token_type_id;
                $availableRoutes = TokenType::find($tokenTypeId)->first()->services->pluck('name')->toArray();
                $requestRoute = request()->route()->getName();
                if (in_array($requestRoute, $availableRoutes)) {
                    Auth::setUser($key->tokenable);
                    return $next($request);
                }
            }
        }

        if ($request->header('Authorization')) {
            $authorizationHeader = $request->header('Authorization');
            if (strpos($authorizationHeader, 'Basic ') === 0) {
                $encodedCredentials = substr($authorizationHeader, 6);
                $decodedCredentials = base64_decode($encodedCredentials);
                list($username, $password) = explode(':', $decodedCredentials, 2);

                $logPass = LogPass::where('login', $username)->first();
                if ($logPass && LogPass::where('login', $username)->where('password', hash('sha256', $password))->exists()) {
                    $tokenTypeId = $logPass->tokenable->token_type_id;
                    $availableRoutes = TokenType::find($tokenTypeId)->first()->services->pluck('name')->toArray();
                    $requestRoute = request()->route()->getName();
                    if (in_array($requestRoute, $availableRoutes)) {
                        Auth::setUser($logPass->tokenable);
                        return $next($request);
                    }
                }
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
