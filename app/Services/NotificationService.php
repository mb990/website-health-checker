<?php


namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService
{
    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }
}
