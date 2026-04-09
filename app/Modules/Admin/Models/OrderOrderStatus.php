<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_order_status';
    protected $guarded = [];
    protected $fillable = [
        'order_id',
        'order_status_id',
        'supplier_order_id',
        'note',
    ];
}
