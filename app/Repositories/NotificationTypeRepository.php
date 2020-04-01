<?php


namespace App\Repositories;

use App\NotificationType;

class NotificationTypeRepository
{
    protected $notificationType;

    public function __construct(NotificationType $notificationType)
    {
        $this->notificationType = $notificationType;
    }

    public function all() {

        return $this->notificationType->all();
    }

    public function findByName($name) {

        return $this->notificationType->where('name', '=', $name)->first();
    }
}
