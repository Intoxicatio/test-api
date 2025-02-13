<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function generateToken(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'token' => 'required|string|in:basic,bearer,key',
        ]);

        $account = Account::find($request->account_id);

        switch ($request->token) {
            case 'basic':
                $request->validate([
                    'login' => 'required|unique:log_pass,login',
                    'password' => 'required',
                ]);
                $token = $account->createBasic($request->login, $request->password);
                break;
            case 'bearer':
                $token = $account->createBearerToken();
                break;
            case 'key':
                $token = $account->createApiKey();
                break;
        }

        return response()->json($token, 200);
    }

    public function login(Request $request)
    {
        return response()->json(['message' => 'You are logged in'], 200);
    }

    public function register(Request $request)
    {
        return response()->json(['message' => 'You are registered'], 200);
    }
}
