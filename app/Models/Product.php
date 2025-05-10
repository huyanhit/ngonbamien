<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SoftDeletes, Filterable;
    protected $softDelete = true;
    protected $table = 'products';

    protected $hidden = [
       'price_root'
    ];

    protected $casts =[
        'is_hot'=> 'boolean',
        'is_promotion'=> 'boolean',
        'is_new'=> 'boolean'
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function product_option(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id', 'id')
            ->select('product_option.id', 'product_option.option_price_id', 'product_option.title',
                'product_option.stock', 'product_option.discount', 'product_option.price_root', 'product_option.price');
    }
}
