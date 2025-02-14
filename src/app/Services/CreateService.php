<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Company;
use App\Models\Service;

class CreateService
{
    public static function createCompany(string $companyName)
    {
        $company = Company::where('name', $companyName)->first();
        if ($company !== null) {
            return "Company {$companyName} already exists";
        } else {
            return Company::create(['name' => $companyName])->name;
        }
    }

    public static function createAccount(array $accountData)
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
        ]);
    }

    public function addService() {}
}
