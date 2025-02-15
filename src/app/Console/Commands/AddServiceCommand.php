<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\TokenType;
use App\Services\CreateService;
use Illuminate\Console\Command;

class AddServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:service';

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
            $services = Service::pluck('name')->toArray();
            $services[] = 'Add new service...';
            $serviceName = $this->choice('Select service', $services);
            if ($serviceName === 'Add new service...') {
                $serviceName = $this->ask('Enter service name');
                CreateService::service($serviceName);
            } else {
                break;
            }
        }

        while (true) {
            $tokens = TokenType::pluck('name')->toArray();
            $tokens[] = 'Add new token type...';
            $typeName = $this->choice('What token types will this service have?', $tokens);
            if ($typeName === 'Add new token type...') {
                $typeName = $this->ask('Enter new type of token');
                CreateService::tokenType($typeName);
            } else {
                CreateService::attachType($serviceName, $typeName);
                if ($this->choice('Attach token yet?', ['Yes', 'No']) === 'No') {
                    break;
                }
            }
        }
        $pivot = Service::where('name', $serviceName)->first()->tokenTypes->pluck('name');
        return $this->info("Service {$serviceName} have {$pivot} ");
    }
}
