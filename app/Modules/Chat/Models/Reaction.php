<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use HasFactory, SoftDeletes;

    protected  $table = 'chat_reactions';

    protected $fillable = [
        'room_id', 'user_id', 'message_id', 'emoji_id'
    ];
}
