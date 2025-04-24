<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use HasFactory;

    protected $table = 'post_categories';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Posts::class, 'post_category_id', 'id');
    }
}
