<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'creator', 'viewer'];

        foreach ($roles as $role) {
            $role = Role::create(['name' => $roles[0]]);

            array_shift($roles);
        }
    }
}
