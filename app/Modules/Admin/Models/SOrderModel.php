<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class SOrderModel extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded = [];
    protected $table = 'supplier_orders';

    protected $appends = ['date_ship'];

    public function products():BelongsToMany
    {
        return $this->belongsToMany(ProductModel::class, 'order_products', 'order_id', 'product_id')
            ->withPivot(['quantity', 'options', 'price']);
    }

    public function getDateShipAttribute()
    {
        return Carbon::parse($this->created_at)->addDays(3);
    }

    public function order_order_status(): HasMany
    {
        return $this->hasMany(OrderOrderStatus::class, 'order_id');
    }

    public function supplier_order_status(): HasMany
    {
        return $this->hasMany(OrderOrderStatus::class, 'order_id', 'order_id');
    }
}
