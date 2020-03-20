<?php

use Illuminate\Database\Seeder;

class ProjectUrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProjectUrl::class, 5)->create();
    }
}
