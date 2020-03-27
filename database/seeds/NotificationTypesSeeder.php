<?php

use Illuminate\Database\Seeder;
use App\NotificationType;

class NotificationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['url_down', 'url_up', 'member_joined_team', 'member_left_team'];

        foreach ($types as $type) {
            $type = new NotificationType();

            $type->name = $types[0];

            $type->save();

            array_shift($types);
        }
    }
}
