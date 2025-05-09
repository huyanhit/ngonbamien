<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'product_categories';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function producers(): BelongsToMany
    {
        return $this->belongsToMany(Producer::class, 'products', 'product_category_id', 'producer_id')->distinct('producer_id');
    }
}
