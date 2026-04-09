<?php

namespace App\Modules\Notification\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='notify_notifications';

    protected $fillable = [
        'id', 'auth_id', 'title', 'content', 'extra', 'url', 'action', 'type_id'
    ];

    public function authNotify(): HasOne
    {
        return $this->hasOne(UserNotification::class, 'notify_id', 'id')->where('user_id', Auth::id());
    }

    public function auth(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'auth_id');
    }
}
