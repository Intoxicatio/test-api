<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Company;
use App\Models\Service;
use App\Services\CreateService;
use App\Services\TokenService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class CreateAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        while (true) {

            $companies = Company::pluck('name')->toArray();
            $companies[] = 'Create new company...';
            $companyName = $this->choice('Select the company', $companies);

            if ($companyName === 'Create new company...') {
                $companyName = $this->ask('Enter company name');
                CreateService::createCompany($companyName);
            } else {
                break;
            }
        }

        $services = Service::pluck('name')->toArray();
        $serviceName = $this->choice('Choose the service', $services);

        $accountName = $this->ask('Enter account name');

        $token = $this->choice('Choose the authentification type', ['basic', 'bearer', 'api_key']);
        $data['token'] = $token;
        if ($token === 'basic') {
            $this->info('Enter login and password');
            $data['login'] = $this->ask('Login');
            $data['password'] = $this->ask('Password');
        }

        DB::beginTransaction();

        try {

            $account = CreateService::createAccount([
                'accountName' => $accountName,
                'companyName' => $companyName,
                'serviceName' => $serviceName
            ]);
        } catch (Exception $exc) {
            $this->error("First\n" . $exc);
            DB::rollBack();
        }

        DB::commit();

        DB::beginTransaction();
        try {
            $data['account_id'] = $account->id;

            $auth = TokenService::generate($data);
        } catch (Exception $exc) {
            $this->error("Second\n" . $exc);
            DB::rollBack();
        }

        DB::commit();

        return 0;
    }
}
