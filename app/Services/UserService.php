<?php


namespace App\Services;

use App\Repositories\UserRepository;
class UserService
{
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function createdProjects() {
dd($this->user->createdProjects());
        return $this->user->createdProjects();
    }
}
