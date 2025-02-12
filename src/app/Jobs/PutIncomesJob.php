<?php

namespace App\Jobs;

use App\Models\Income;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PutIncomesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The response data.
     *
     * @var array
     */
    protected $responseData;

    /**
     * Create a new job instance.
     *
     * @param array $responseData
     * @return void
     */
    public function __construct(array $responseData)
    {
        $this->responseData = $responseData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $i = 0;
        foreach ($this->responseData as $data) {
            Income::updateOrCreate([
                'income_id' => $data['income_id'],
                'number' => $data['number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'total_price' => $data['total_price'],
                'date_close' => $data['date_close'],
                'warehouse_name' => $data['warehouse_name'],
                'nm_id' => $data['nm_id'],
            ]);
            $i++;
        }
        return Log::info("{$i} Incomes added to database");
    }
}
