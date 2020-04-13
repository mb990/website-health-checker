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

    public function store($user, $project, $type) {

        $this->projectRole->create([
           'user_id' => $user->id,
           'project_id' => $project->id,
           'project_role_type_id' => $type->id
        ]);
    }
}
