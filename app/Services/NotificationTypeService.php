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

    public function findByName($name) {

        return $this->notificationType->findByName($name);
    }

    public function findById($id) {

        return $this->notificationType->findById($id);
    }
}
