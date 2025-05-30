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
        'total',
        'discount',
        'ship_type',
        'ship_price',
        'user_id',
        'order_status_id'
    ];

    protected $appends = ['date_ship'];

    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot(['quantity', 'options', 'price']);
    }

    public function getDateShipAttribute()
    {
        return Carbon::parse($this->created_at)->addDays(3);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
