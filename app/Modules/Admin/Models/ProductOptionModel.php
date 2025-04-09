<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionModel extends Model
{
    use HasFactory;
    protected $table = 'product_option';

    protected $fillable = [
        'product_id',
        'option_price_id',
        'title', 'price_root', 'price',
        'discount', 'stock',
    ];
}
