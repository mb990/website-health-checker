<?php


namespace App\Repositories;

use App\ProjectRole;

class ProjectRoleRepository
{
    protected $projectRole;

    public function __construct(ProjectRole $projectRole)
    {
        $this->projectRole = $projectRole;
    }

    public function find($user, $project) {

        return $this->projectRole->where('user_id', '=', $user->id)
            ->where('project_id', '=', $project->id)
            ->first();
    }

    public function store($user, $project, $type) {

        $this->projectRole->create([
           'user_id' => $user->id,
           'project_id' => $project->id,
           'project_role_type_id' => $type->id
        ]);
    }

    public function delete($user, $project) {

        return $this->projectRole->where('user_id', '=', $user->id)
            ->where('project_id', '=', $project->id)
            ->delete();
    }

    public function hasRole($user, $project, $role) {

        return $this->projectRole->where('user_id', '=', $user->id)
            ->where('project_id', '=', $project->id)
            ->where('project_role_type_id', '=', $role->id)
            ->first();
    }
}
