<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\User;
use App\Services\NotificationSettingServiceService;

class UserService
{
    protected $notificationTypeService;

    public function __construct(UserRepository $user, NotificationSettingService $notificationSettingService)
    {
        $this->user = $user;
        $this->notificationSettingService = $notificationSettingService;
    }

    public function findById($id) {

        return $this->user->find($id);
    }

    public function findBySlug($slug) {

        return $this->user->findBySlug($slug);
    }

    public function hasNotificationActive($user, $type) {

        $notification = $this->notificationSettingService->findByUserAndType($user, $type);

        if ($notification->active) {
            return true;
        }
        else {
            return false;
        }
    }
}
