<?php


namespace App\Services;

use App\Repositories\FrequencyRepository;

class FrequencyService
{
    public function __construct(FrequencyRepository $frequency)
    {
        $this->frequency = $frequency;
    }

    public function all() {

        return $this->frequency->all();
    }
}
