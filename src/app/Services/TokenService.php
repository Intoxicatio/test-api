<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Account;

class TokenService
{
    public static function generate(array $data)
    {
        $validator = Validator::make($data, [
            'account_id' => 'required|exists:accounts,id',
            'token' => 'required|string|in:basic,bearer,api_key',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $account = Account::find($data['account_id']);

        switch ($data['token']) {

            case 'basic':

                $validator = Validator::make($data, [
                    'login' => 'required|unique:log_pass,login',
                    'password' => 'required',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $token = $account->createBasic($data['login'], $data['password']);
                break;

            case 'bearer':

                $token = $account->createBearerToken();
                break;

            case 'api_key':

                $token = $account->createApiKey();
                break;
        }

        return $token;
    }
}
