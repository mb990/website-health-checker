<?php


namespace App\Repositories;

use App\Frequency;

class FrequencyRepository
{
    protected $frequency;

    public function __construct(Frequency $frequency)
    {
        $this->frequency = $frequency;
    }

    public function all() {

        return $this->frequency->all();
    }
}
