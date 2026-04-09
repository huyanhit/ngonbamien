<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'code',
        'name',
        'phone',
        'address',
        'note',
        'coupon',
        'ship_type',
        'ship_price',
        'down_price',
        'discount',
        'total',
        'user_id',
        'order_status_id',
        'order_id',
        'active'
    ];

    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot(['quantity', 'options', 'price']);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function supplier_order_status(): HasMany
    {
        return $this->hasMany(OrderOrderStatus::class, 'supplier_order_id');
    }
}
