<?php


namespace App\Repositories;

use App\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findById($id) {

        return $this->user->find($id);
    }

    public function findBySlug($slug) {

        return $this->user->where('slug', '=', $slug)->first();
    }

//    public function hasNotification($user, $type)
//    {
//        $notification = $user->whereHas('notificationSettings', function ($q) use ($type) {
//            $q->where('name', '=', $type);
//            })->first();
//
//        if ($notification->active) {
//            return true;
//        }
//        else {
//            return false;
//        }
//    }
}
