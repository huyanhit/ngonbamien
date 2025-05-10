<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavorProduct extends Model
{
    use HasFactory;
    protected $table = 'favor_products';
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
