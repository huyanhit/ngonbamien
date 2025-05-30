<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'product_id',
        'name',
        'rating',
        'content',
        'active'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i d-m-Y');
    }
}
