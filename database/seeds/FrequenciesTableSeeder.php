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
        $frequencyValues = [59, 299, 899, 1799, 3599, 43199, 86399];

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
