<?php


namespace App\Repositories;

use App\Invite;

class InviteRepository
{
    protected $invite;

    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    public function store($token, $email) {

        return $this->invite->create([
            'email' => $email,
            'token' => $token
        ]);
    }

    public function delete($token) {

        return $this->invite->where('token', '=', $token)->delete();
    }

    public function findByToken($token) {

        return $this->invite->where('token', '=', $token)->first();
    }
}
