<?php


namespace App\Services;

use App\Repositories\ProjectRoleRepository;
use App\Services\ProjectRoleTypeService;

class ProjectRoleService
{
    protected $projectRole;
    protected $projectRoleType;

    public function __construct(ProjectRoleRepository $projectRole, ProjectRoleTypeService $projectRoleType)
    {
        $this->projectRole = $projectRole;
        $this->projectRoleType = $projectRoleType;
    }

    public function find($user, $project) {

        return $this->projectRole->find($user, $project);
    }

    public function assignProjectRole($user, $project, $type) {

        $projectRole = $this->projectRoleType->findByName($type);

        return $this->projectRole->store($user, $project, $projectRole);
    }

    public function removeProjectRole($user, $project) {

        return $this->projectRole->delete($user, $project);
    }

    public function hasRole($user, $project, $role) {

        $projectRole = $this->projectRoleType->findByName($role);

        if ($this->projectRole->hasRole($user, $project, $projectRole)) {

            return true;
        }

        return false;
    }
}
