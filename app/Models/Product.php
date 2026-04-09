<?php

namespace App\Models;

use App\Traits\Filterable;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    
    protected $appends = ['is_hot', 'is_new', 'is_promotion'];

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

    public function author(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'auth_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->BelongsTo(Supplier::class, 'supplier_id');
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function product_option(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id', 'id');
    }

    public function recent(): HasMany{
        return $this->hasMany(ProductRecent::class, 'product_id', 'id')
            ->where('user_id', Auth::id());
    }

    protected function isHot(): Attribute
    {
        return Attribute::get(
            fn () => $this->sell > 30,
        );
    }

    protected function isNew(): Attribute
    {
        return Attribute::get(
            fn () => $this->created_at > (new DateTime())->modify('-30 day'),
        );
    }

    protected function isPromotion(): Attribute
    {
        return Attribute::get(
            fn () => $this->product_option->every(function ($item) {
                return $item->discount > 0;
            })
        );
    }
}
