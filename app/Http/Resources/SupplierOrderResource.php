<?php

namespace App\Http\Resources;

use App\Models\OrderStatus;
use App\Models\Supplier;
use App\Models\SupplierShip;
use App\Modules\Admin\Models\SupplierOrderModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ship = SupplierShip::where('supplier_id', $this->supplier_id)->first();
        return [
            'order_status_id'    => $this->order_status_id,
            'order_status_title' => OrderStatus::find($this->order_status_id)->title,
            'payment'    => $this->payment,
            'code'       => $this->code,
            'name'       => $this->name,
            'total'      => $this->total,
            'discount'   => $this->discount,
            'ship_price' => $this->ship_price,
            'down_price' => $this->down_price,
            'supplier'   => (new SupplierResource(Supplier::find($this->supplier_id)))->resolve(),
            'products'   => ProductResource::collection(SupplierOrderModel::find($this->id)->products),
            'ship_id'    => $ship?$ship['ship_id']:0,
        ];
    }
}
