<?php

namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PutSalesJob implements ShouldQueue
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
            Sale::create([
                'g_number' => $data['g_number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'total_price' => $data['total_price'],
                'discount_percent' => $data['discount_percent'],
                'is_supply' => $data['is_supply'],
                'is_realization' => $data['is_realization'],
                'promo_code_discount' => $data['promo_code_discount'],
                'warehouse_name' => $data['warehouse_name'],
                'country_name' => $data['country_name'],
                'oblast_okrug_name' => $data['oblast_okrug_name'],
                'region_name' => $data['region_name'],
                'income_id' => $data['income_id'],
                'sale_id' => $data['sale_id'],
                'odid' => $data['odid'],
                'spp' => $data['spp'],
                'for_pay' => $data['for_pay'],
                'finished_price' => $data['finished_price'],
                'price_with_disc' => $data['price_with_disc'],
                'nm_id' => $data['nm_id'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'is_storno' => $data['is_storno'],
            ]);
            $i++;
        }
        Log::info("{$i} Sales added to database");
    }
}
