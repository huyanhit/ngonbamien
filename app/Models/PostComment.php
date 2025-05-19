<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $table = 'post_comments';
    protected $fillable = [
        'post_id',
        'name',
        'content',
        'active'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i d-m-Y');
    }
}
