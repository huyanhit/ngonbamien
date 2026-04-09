<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'       => $this->code,
            'name'       => $this->name,
            'created_at' => $this->created_at,
            'products'   => $this->products,
            'total'      => $this->total,
            'discount'   => $this->discount,
            'ship_price' => $this->ship_price,
            'down_price' => $this->down_price,
            'payment'    => $this->payment,
            'order_status_id' => $this->order_status_id,
            'supplier_orders' => SupplierOrderResource::collection($this->supplier_orders),
        ];
    }
}
