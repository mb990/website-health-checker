<?php

namespace App\Http\Controllers;

use App\Services\NotificationSettingService;

class NotificationSettingController extends Controller
{
    protected $notificationSettingService;

    public function __construct(NotificationSettingService $notificationSettingService)
    {
        $this->notificationSettingService = $notificationSettingService;
    }

    public function all($slug) {

        $settings = $this->notificationSettingService->all();

        return view('settings')->with('settings', $settings);
    }
}
