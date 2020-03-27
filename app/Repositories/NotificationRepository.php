<?php


namespace App\Repositories;

use App\Notification;

class NotificationRepository
{

    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }


}
