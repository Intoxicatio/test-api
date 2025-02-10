<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PutOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $responseData;

    /**
     * Create a new job instance.
     *
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
            Order::create([
                'g_number' => $data['g_number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'total_price' => $data['total_price'],
                'discount_percent' => $data['discount_percent'],
                'warehouse_name' => $data['warehouse_name'],
                'oblast' => $data['oblast'],
                'income_id' => $data['income_id'],
                'odid' => $data['odid'],
                'nm_id' => $data['nm_id'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'is_cancel' => $data['is_cancel'],
                'cancel_dt' => $data['cancel_dt'],
            ]);
            $i++;
        }
        Log::info("{$i} Orders added to database");
    }
}
