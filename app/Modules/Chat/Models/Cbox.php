<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cbox extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'c_box';
    protected $fillable = [
        'token', 'ip', 'room_id', 'active', 'supplier_id'
    ];
}
