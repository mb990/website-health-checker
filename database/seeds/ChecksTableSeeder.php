<?php

use Illuminate\Database\Seeder;

class ChecksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Check::class, 50)->create();
    }
}
