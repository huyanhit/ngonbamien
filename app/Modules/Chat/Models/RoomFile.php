<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_room_file';

    protected $fillable = [
        'room_id', 'file_id'
    ];
}
