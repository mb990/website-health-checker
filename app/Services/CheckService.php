<?php


namespace App\Services;


use App\Repositories\CheckRepository;

class CheckService
{
    public function __construct(CheckRepository $check)
    {
        $this->check = $check;
    }

}
