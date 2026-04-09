<?php

namespace App\Services;

use App\Modules\Notification\Repositories\NotificationRepositoryInterface;
use App\Modules\Notification\Services\NotificationService as NService;

class NotificationService
{
    /**
     * @param $command
     * <p>Tên command push notification.</p>
     * @param array $params
     * <p>array các props như sau</p>
     * <p> - from: id user gửi thông báo.</p>
     * <p> - tos: required - array các ids của user nhận thông báo.</p>
     * @return void
     */
    public static function pushNotification($command, array $params = []): void
    { 
       
        $notification = new NService(resolve(NotificationRepositoryInterface::class));
        $notification->pushNotification($command, $params);
    }
}
