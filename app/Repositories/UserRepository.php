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

    public function createdProjects() {
        dd($this->user->createdProjects());
        return $this->user->createdProjects();
    }
}
