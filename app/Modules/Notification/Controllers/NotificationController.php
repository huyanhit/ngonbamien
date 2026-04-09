<?php

namespace App\Modules\Notification\Controllers;

use App\Modules\Notification\Requests\UpdateSettingRequest;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use App\Modules\Notification\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function summary(): JsonResponse
    {
        try {
            $summary = $this->notificationService->getSummary();
            return $this->sendResponse($summary);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function settingDefault(): JsonResponse
    {
        try {
            return $this->sendResponse($this->notificationService->getUserSettingDefault());
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function settingByObject(): JsonResponse
    {
        try {
            $setting = $this->notificationService->getUserSetting();
            return $this->sendResponse($setting);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function updateSetting(UpdateSettingRequest $request, $id): JsonResponse
    {
        try {
            return $this->sendResponse($this->notificationService->updateSetting($id, $request->all()));
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $notifications = $this->notificationService->getNotifications();
            return $this->sendResponse($notifications, __('common.action_success.list'));
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try { 
            $params = $request->only('read'); 
            return $this->sendResponse(
                $this->notificationService->updateNotification($id, $params) , __('common.action_success.update')
            );
        }
        catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            return $this->sendResponse($this->notificationService->deleteNotification($id));
        }
        catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }
}
