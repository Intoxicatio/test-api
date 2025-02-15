<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Company;
use App\Models\Service;
use App\Models\TokenType;

class CreateService
{
    public static function attachType(string $serviceName, string $typeName)
    {
        $service = Service::where('name', $serviceName)->first();
        $token = TokenType::where('name', $typeName)->first();
        $token->services()->attach($service->id);
    }
    public static function tokenType($tokenTypeName)
    {
        $tokenType = TokenType::where('name', $tokenTypeName)->first();
        if ($tokenType !== null) {
            return "{$tokenTypeName} token type already exists";
        } else {
            return TokenType::create(['name' => $tokenTypeName])->name;
        }
    }
    public static function service($serviceName)
    {
        $service = Service::where('name', $serviceName)->first();
        if ($service !== null) {
            return "Service {$serviceName} already exists";
        } else {
            return Service::create(['name' => $serviceName])->name;
        }
    }
    public static function company(string $companyName)
    {
        $company = Company::where('name', $companyName)->first();
        if ($company !== null) {
            return "Company {$companyName} already exists";
        } else {
            return Company::create(['name' => $companyName])->name;
        }
    }

    public static function account(array $accountData)
    {
        $account = Account::where('name', $accountData['accountName'])->first();
        if ($account !== null) {
            return 'This account already exists';
        }

        $company = Company::where('name', $accountData['companyName'])->first();
        if ($company === null) {
            return 'Company not found';
        }

        $service = Service::where('name', $accountData['serviceName'])->first();
        if ($service === null) {
            return 'Service not found';
        }

        return $company->accounts()->create([
            'name' => $accountData['accountName'],
            'service_id' => $service->id,
            'token_type_id' =>$accountData['tokenTypeId']
        ]);
    }
}
