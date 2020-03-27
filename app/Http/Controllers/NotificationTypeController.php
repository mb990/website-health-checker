<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationTypeService;

class NotificationTypeController extends Controller
{
    protected $notificationTypeService;

    public function __construct($notificationTypeService)
    {
        $this->notificationTypeService = $notificationTypeService;
    }
}
