<?php

namespace App\Modules\Notification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSettingNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='notify_user_setting_notification';

    protected $fillable = [
        'user_id',
        'module',
        'router',
        'command',
        'position',
        'auto_close',
        'sound',
        'is_notify',
        'is_mute',
        'is_send',
    ];
}
