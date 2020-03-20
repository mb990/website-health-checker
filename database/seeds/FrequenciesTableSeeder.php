<?php

use Illuminate\Database\Seeder;
use App\Frequency;

class FrequenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frequencyValues = [60, 300, 900, 1800, 3600, 43200, 86400];

        $frequencyNames = ['1 minute', '5 minutes', '15 minutes', '30 minutes', '1 hour', '12 hours', 'a day'];

        foreach ($frequencyValues as $frequency) {
            $frequency = new Frequency();

            $frequency->value = $frequencyValues[0];
            $frequency->name = $frequencyNames[0];

            $frequency->save();

            array_shift($frequencyValues);
            array_shift($frequencyNames);
        }
    }

}
