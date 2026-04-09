<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chat_messages';
    protected $primaryKey = 'ids';
    protected $fillable = [
        'id', 'content', 'room_id', 'status', 'auth', 'thread'
    ];
}
