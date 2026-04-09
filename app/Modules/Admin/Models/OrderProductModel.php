<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProductModel extends Pivot
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded = [];
    protected $table = 'order_product';
}
