<?php

namespace App\Http\Controllers;

use App\Services\NotificationSettingService;
use App\Services\UserService;

class NotificationSettingController extends Controller
{
    protected $notificationSettingService;
    protected $userService;

    public function __construct(NotificationSettingService $notificationSettingService,  UserService $userService)
    {
        $this->notificationSettingService = $notificationSettingService;
        $this->userService = $userService;
    }

    public function all($slug) {

        $user = $this->userService->findBySlug($slug);

        $settings = $this->notificationSettingService->findByUser($user);

        return view('settings')->with('settings', $settings);
    }
}
