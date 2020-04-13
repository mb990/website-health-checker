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

    public function assignProjectRole($user, $project, $type) {

        $projectRole = $this->projectRoleType->findByName($type);

        return $this->projectRole->store($user, $project, $projectRole);
    }
}
