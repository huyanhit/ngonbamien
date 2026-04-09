<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoom extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'chat_user_room';

    protected $fillable = [
        'user_id', 'room_id', 'type', 'position'
    ];
}
