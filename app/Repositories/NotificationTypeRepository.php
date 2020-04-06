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

    public function findByName($type) {

        return $this->notificationType->where('name', '=', $type->name)->first();
    }

    public function findById($id) {

        return $this->notificationType->where('id', '=', $id)->first();
    }

//    public function findByUser($user) {
//
//        return $this->notificationType->whereHas('users', function ($q) use ($user) {
//            $q->where('user_id', '=', $user->id);
//        })->get();
//    }
}
