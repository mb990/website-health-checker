<?php

use Illuminate\Database\Seeder;
use App\ProjectRoleType;

class ProjectRoleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectRoles = ['creator', 'viewer'];

        foreach ($projectRoles as $projectRole) {
            $projectRole = ProjectRoleType::create(['name' => $projectRoles[0]]);

            array_shift($projectRoles);
        }
    }
}
