<?php


namespace App\Services;

use App\Http\Requests\NotificationSettingRequest;
use App\Repositories\NotificationSettingRepository;
use App\Services\NotificationTypeService;

class NotificationSettingService
{
    protected $notificationTypeService;

    public function __construct(NotificationSettingRepository $notificationSetting, NotificationTypeService $notificationTypeService)
    {
        $this->notificationSetting = $notificationSetting;
        $this->notificationTypeService = $notificationTypeService;
    }

    public function all() {

        return $this->notificationSetting->all();
    }

    public function findById($id) {

        return $this->notificationSetting->findById($id);
    }

    public function findByUser($user) {

        return $this->notificationSetting->findByUser($user);
    }

    public function findByUserAndType($user, $name) {

        $type = $this->notificationTypeService->findByName($name);

        return $this->notificationSetting->findByUserAndType($user, $type);
    }

    public function subscribeUserToNotifications($user, $project) {

        $notificationTypes = $this->notificationTypeService->all();

        foreach ($notificationTypes as $type) {

            $this->notificationSetting->subscribeUserToNotifications($user, $project, $type);
        }
    }

    public function update(NotificationSettingRequest $request, $id) {

        $notificationSetting = $this->notificationSetting->find($id);

        $this->notificationSetting->update($request, $notificationSetting);
    }
}
