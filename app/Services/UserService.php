<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\NotificationSettingService;
class UserService
{
    protected $notificationSettingService;

    public function __construct(UserRepository $user, NotificationSettingService $notificationSettingService)
    {
        $this->user = $user;
        $this->notificationSettingService = $notificationSettingService;
    }

    public function all() {

        return $this->user->all();
    }

    public function findById($id) {

        return $this->user->findById($id);
    }

    public function findBySlug($slug) {

        return $this->user->findBySlug($slug);
    }

    public function hasNotificationActive($user, $type)
    {

        $notification = $this->notificationSettingService->findByUserAndType($user, $type);
//        dd($notification);

        if (isset($notification)) {
            if ($notification->active) {
                return true;
            }
        }

        return false;
    }
}
