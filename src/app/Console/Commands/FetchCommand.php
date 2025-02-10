<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchService;

class FetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from API';

    /**
     * The FetchService instance.
     *
     * @var FetchService
     */
    protected $fetchService;

    /**
     * Create a new command instance.
     *
     * @param FetchService $fetchService
     */
    public function __construct(FetchService $fetchService)
    {
        parent::__construct();
        $this->fetchService = $fetchService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->argument('type');

        if (!in_array($type, ['orders', 'incomes', 'sales', 'stocks'])) {
            return $this->error('Invalid type');
        }

        $output = $this->fetchService->fetch($type);

        return $this->info($output . "\n");
    }
}
