<?php

namespace App\Modules\Notification\Services;

use App\Modules\Notification\Config\Constants;
use App\Modules\Notification\Repositories\NotificationRepositoryInterface;
use App\Modules\Notification\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;
use App\Services\SocketService;

class NotificationService
{
    protected $notificationRepository;
    protected $socketService;

    public function __construct(NotificationRepositoryInterface $notificationRepository){
        $this->notificationRepository = $notificationRepository;
    }

    public function updateNotification($id, $params)
    {
        return $this->notificationRepository->updateNotification($id, $params);
    }

    public function deleteNotification($id)
    {
        return $this->notificationRepository->deleteNotification($id);
    }

    public function getSummary()
    {
        return $this->notificationRepository->getSummary();
    }

    public function getNotifications()
    {
        return NotificationResource::collection($this->notificationRepository->getNotifications())->resource;
    }

    public function processParamByConfig($command, &$params): array
    {
        $auth = Auth::user();
        $params['auth_name']   = $auth?->username;
        $params['auth_avatar'] = $auth?->avatar;

        $configs  = [];
        if(isset(Constants::command[$command])){
            $commands = Constants::command[$command]; 
            foreach ($commands as $key => $command){
                $regx = '/\{\w+\}/';
                $configs[$key] = preg_replace_callback($regx, function($match) use ($params){
                    $match = substr($match[0], 1, -1);
                    return $params[$match] ?? '';
                }, $command);
            }
        }
       
        return $configs;
    }

    public function getUserSettingDefault(): array
    {
        return $this->notificationRepository->getUserSettingDefault(Auth::id());
    }

    public function getUserSetting(): array
    {
        $settings = [];
        $commands = $commands = Constants::command;
        foreach (array_keys($commands) as $command){
            $data = $this->notificationRepository->getUserSettingCommand(Auth::id(), $command);
            if(!empty($data)){
                $settings[] = $data;
            }
        }

        return $settings;
    }

    public function updateSetting($id, $param)
    {
        return $this->notificationRepository->updateSetting($id, $param);
    }

    public function pushNotification($command, $params)
    {
        $authID  = $params['from']?? Auth::id();
        $users   = $params['tos']?? [];
        $configs = $this->processParamByConfig($command, $params);
         
        if($notify = $this->notificationRepository->saveNotification($authID, $params, $configs)){
            $this->socketService = new SocketService();
            $this->socketService->connect();
            foreach ($users as $userId){ 
                $setting = $this->notificationRepository->getUserSettingDefault($userId);
                $object  = $this->notificationRepository->getUserSettingCommand($userId, $command);
            
                $setting['is_notify'] = $object['is_notify']?? 0;
                $setting['is_send']   = $object['is_send']?? 0;
                $setting['is_mute']   = $object['is_mute']?? 0;
                $setting['command']   = $object['command']?? $command;

                if($setting){
                    if($setting['is_notify'] || ($setting['staffs'] && in_array($authID, json_decode($setting['staffs'])))){
                        $this->notificationRepository->saveUserNotification($notify->id, $userId, $userId === Auth::id());
                        $this->emitNotification($userId, $params, $configs, $setting);
                    }
                    if($setting['is_send']){
                        $this->sendMailNotification($userId, $params, $configs, $setting);
                    }
                }
            }
            
            $this->socketService->disconnect();

            return $notify;
        }
    }

    private function emitNotification($userId, $params, $configs, $setting): void
    {
        $this->socketService->emit([
            'channel' => 'USER_' . $userId,
            'event'   => 'notification',
            'data'    => [
                'title'      => $configs['title'],
                'text'       => $configs['content'],
                'type_id'    => $configs['type'],
                'url'        => $configs['url']?? '',
                'auth_avatar'=> $params['auth_avatar'],
                'auth_name'  => $params['auth_name'],
                'auth_read'  => $userId == Auth::id(),
                'extra'      => json_encode($params),
                'setting'    => $setting,
            ]
        ]);
    }

    private function sendMailNotification($userId, $data, $configs, $setting)
    {
        //todo
    }
}
