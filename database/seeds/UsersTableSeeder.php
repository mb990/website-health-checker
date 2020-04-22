<?php

use Illuminate\Database\Seeder;
use App\Services\UserService;
use App\Services\RegisterService;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $userService;
    protected $registerService;

    public function __construct(UserService $userService, RegisterService $registerService)
    {
        $this->userService = $userService;
        $this->registerService = $registerService;
    }

    public function run()
    {
//        factory(App\User::class, 10)->create();

        // create admin
        $user = new \App\User();

        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->email = 'admin@website-health-checker.com';
        $user->password = $this->registerService->hashPassword('adminadmin');

        $user->save();

        $this->userService->assignRole($user, 'admin');
    }
}
