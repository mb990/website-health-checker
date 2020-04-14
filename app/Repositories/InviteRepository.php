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

    public function all() {

        return $this->invite->all();
    }

    public function store($email, $project, $token) {

        return $this->invite->create([
            'email' => $email,
            'project_id' => $project->id,
            'token' => $token
        ]);
    }

    public function delete($token) {

        return $this->invite->where('token', '=', $token)->delete();
    }

    public function findByProject($project) {

        return $this->invite->where('project_id', '=', $project->id)->get();
    }

    public function findByToken($token) {

        return $this->invite->where('token', '=', $token)->first();
    }

    public function findByEmail($email) {

        return $this->invite->where('email', '=', $email)->first();
    }

    public function deleteExpired($time) {

        return $this->invite->where('created_at', '<', $time)->delete();
    }
}
