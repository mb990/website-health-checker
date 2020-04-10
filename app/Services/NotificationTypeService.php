<?php


namespace App\Services;

use App\Repositories\NotificationTypeRepository;

class NotificationTypeService
{
    public function __construct(NotificationTypeRepository $notificationType)
    {
        $this->notificationType = $notificationType;
    }

    public function all() {

        return $this->notificationType->all();
    }

    public function findByName($type) {

        return $this->notificationType->findByName($type);
    }

    public function findById($id) {

        return $this->notificationType->findById($id);
    }

    public function findByUser($user) {

        return $this->notificationType->findByUser($user);
    }

}
