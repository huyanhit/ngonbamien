<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class SupplierOrderModel extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded = [];
    protected $table = 'supplier_orders';

    protected $appends = ['date_ship'];

    public function products():BelongsToMany
    {
        return $this->belongsToMany(ProductModel::class, 'order_products', 'supplier_order_id', 'product_id')
            ->withPivot(['quantity', 'options', 'price']);
    }

    public function getDateShipAttribute()
    {
        $sShip = SupplierModel::find($this->supplier_id)->supplier_ship;
        if($sShip->isNotEmpty()){
            switch ($sShip[0]->ship_id) {
                case '1':
                    return Carbon::parse($this->created_at)->addDays(2);
                case '2':
                    return Carbon::parse($this->created_at)->addDays(4);
            }
        }else{
            return Carbon::parse($this->created_at)->addDays(4);
        }
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function order_order_status(): HasMany
    {
        return $this->hasMany(OrderOrderStatus::class, 'order_id', 'order_id');
    }

    public function supplier_order_status(): HasMany
    {
        return $this->hasMany(OrderOrderStatus::class, 'supplier_order_id');
    }
}
