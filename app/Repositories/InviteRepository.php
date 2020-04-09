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

    public function store($user, $project, $token) {

        return $this->invite->create([
            'user_id' => $user->id,
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

    public function checkForDeletion($invites, $time) {

        return $this->invite->where('created_at', '<', $time)->delete();
    }
}
