<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleRoom extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'chat_module_room';

    protected $fillable = [
        'module', 'object_id', 'room_id'
    ];
}
