<?php


namespace App\Services;

use App\Http\Requests\NotificationSettingRequest;
use App\Repositories\NotificationSettingRepository;
use App\Services\NotificationTypeService;
use App\Services\UserService;

class NotificationSettingService
{
    protected $notificationTypeService;
    protected $userService;

    public function __construct(NotificationSettingRepository $notificationSetting, NotificationTypeService $notificationTypeService,
                        UserService $userService)
    {
        $this->notificationSetting = $notificationSetting;
        $this->notificationTypeService = $notificationTypeService;
        $this->userService = $userService;
    }

    public function findById($id) {

        return $this->notificationSetting->findById($id);
    }

    public function findByUser($slug) {

        $user = $this->userService->findBySlug($slug);

        return $this->notificationSetting->findByUser($user);
    }

    public function findByUserAndType($user, $type) {

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
