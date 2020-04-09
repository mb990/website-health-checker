<?php


namespace App\Repositories;

use App\User;
use function foo\func;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all() {

        return $this->user->all();
    }

    public function findById($id) {
//dd($id);
        return $this->user->find($id);
    }

    public function findBySlug($slug) {

        return $this->user->where('slug', '=', $slug)->first();
    }

//    public function hasNotification($name) {
//
//        return $this->user->whereHas('notifications', function ($q) use ($name) {
//            $q->whereHas('notification_type_id', '=', $name);
//        })->first();
//    }
}
