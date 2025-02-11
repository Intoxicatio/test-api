<?php

namespace App\Jobs;

use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PutStocksJob implements ShouldQueue
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
            Stock::updateOrCreate([
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'is_supply' => $data['is_supply'],
                'is_realization' => $data['is_realization'],
                'quantity_full' => $data['quantity_full'],
                'warehouse_name' => $data['warehouse_name'],
                'in_way_to_client' => $data['in_way_to_client'],
                'in_way_from_client' => $data['in_way_from_client'],
                'nm_id' => $data['nm_id'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'sc_code' => $data['sc_code'],
                'price' => $data['price'],
                'discount' => $data['discount'],
            ]);
            $i++;
        }
        Log::info("{$i} Stocks added to database");
    }
}
