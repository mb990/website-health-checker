<?php


namespace App\Repositories;

use App\ProjectRoleType;

class ProjectRoleTypeRepository
{
    protected $projectRoleType;

    public function __construct(ProjectRoleType $projectRoleType)
    {
        $this->projectRoleType = $projectRoleType;
    }

    public function all() {

        return $this->projectRoleType->all();
    }

    public function findByName($name) {

        return $this->projectRoleType->where('name', '=', $name)->first();
    }
}
