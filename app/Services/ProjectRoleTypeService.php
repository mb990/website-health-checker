<?php


namespace App\Services;

use App\Repositories\ProjectRoleTypeRepository;

class ProjectRoleTypeService
{
    protected $projectRoleType;

    public function __construct(ProjectRoleTypeRepository $projectRoleType)
    {
        $this->projectRoleType = $projectRoleType;
    }

    public function all() {

        return $this->projectRoleType->all();
    }

    public function findByName($name) {

        return $this->projectRoleType->findByName($name);
    }
}
