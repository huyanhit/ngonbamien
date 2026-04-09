<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'product_id',
        'name',
        'rating',
        'phone',
        'content',
        'active'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i d-m-Y');
    }
}
