<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:06 PM
 */

namespace App\Modules;

use App\Modules\Chat\Repositories\ChatRepository;
use App\Modules\Chat\Repositories\ChatRepositoryInterface;
use App\Modules\Notification\Repositories\NotificationRepository;
use App\Modules\Notification\Repositories\NotificationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends  ServiceProvider
{
    public function boot(): void
    {
        $listModule = config("app.modules");
        foreach ($listModule as $module) {
            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                $this->loadRoutesFrom(__DIR__.'/'.$module.'/routes.php');
            }
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }
    }

    public function register() {
        $this->app->bind(ChatRepositoryInterface::class, ChatRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
    }
}
