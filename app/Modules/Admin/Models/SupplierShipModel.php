<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierShipModel extends Model
{
    use HasFactory;
    protected $table = 'supplier_ships';
    protected $guarded = [];
    protected $fillable = [
        'ship_id','supplier_id'
    ];
}
