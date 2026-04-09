<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierSupportModel extends Model
{
    use HasFactory;
    protected $table = 'supplier_supports';
    protected $fillable = [
        'support_id',
        'supplier_id',
        'value_1',
        'value_2',
    ];
}
