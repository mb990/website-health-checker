<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\User;

class UserService
{
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function find($id) {

        return $this->user->find($id);
    }

//    public function createdProjects() {
//dd($this->user->createdProjects());
//        return $this->user->createdProjects();
//    }
}
