<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
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
        'active'
    ];
    protected $appends = ['date_ship'];

    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot(['quantity', 'options', 'price']);
    }

    public function supplier_orders():HasMany
    {
        return $this->hasMany(SupplierOrder::class, 'order_id');
    }
}
