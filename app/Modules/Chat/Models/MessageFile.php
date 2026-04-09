<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_message_file';

    protected $fillable = [
        'message_id', 'file_id'
    ];
}
