<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected  $table = 'chat_rooms';

    protected $fillable = [
        'name', 'description', 'icon', 'type', 'status', 'pin', 'total'
    ];
}
