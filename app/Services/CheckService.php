<?php


namespace App\Services;


use App\Repositories\CheckRepository;

class CheckService
{
    public function __construct(CheckRepository $check)
    {
        $this->check = $check;
    }

    public function allByTime($url) {

        return $this->check->allByTime($url);
    }

    public function read($id) {

        return $this->check->find($id);
    }
}
