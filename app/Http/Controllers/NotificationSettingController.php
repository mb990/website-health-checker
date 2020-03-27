<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationSettingService;

class NotificationSettingController extends Controller
{
    protected $notificationSettingService;

    public function __construct($notificationSettingService)
    {
        $this->notificationSettingService = $notificationSettingService;
    }
}
