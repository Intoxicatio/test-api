<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'g_number' => $this->g_number,
            'date' => $this->date,
            'last_change_date' => $this->last_change_date,
            'supplier_article' => $this->supplier_article,
            'tech_size' => $this->tech_size,
            'barcode' => $this->barcode,
            'total_price' => $this->total_price,
            'discount_percent' => $this->discount_percent,
            'warehouse_name' => $this->warehouse_name,
            'oblast' => $this->oblast,
            'income_id' => $this->income_id,
            'odid' => $this->odid,
            'nm_id' => $this->nm_id,
            'subject' => $this->subject,
            'category' => $this->category,
            'brand' => $this->brand,
            'is_cancel' => $this->is_cancel,
            'cancel_dt' => $this->cancel_dt,
        ];
    }
}
