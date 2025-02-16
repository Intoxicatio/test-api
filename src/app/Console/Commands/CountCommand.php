<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Console\Command;

class CountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count {type}';

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
        $type = $this->argument('type');
        switch ($type) {
            case 'orders': $count = Order::count();
            break;
            case 'sales': $count = Sale::count();
            break;
            case 'incomes': $count = Income::count();
            break;
            case 'stocks': $count = Stock::count();
            break;
        }
        return $this->info($count);
    }
}
