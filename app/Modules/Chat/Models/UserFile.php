<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_user_file';
    protected $fillable = [
        'user_id', 'file_id'
    ];
}
