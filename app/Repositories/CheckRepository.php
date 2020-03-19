<?php


namespace App\Repositories;


use App\Check;

class CheckRepository
{
    protected $check;

    public function __construct(Check $check)
    {
        $this->check = $check;
    }

    public function all() {

        return $this->check->all();
    }

    public function find($id) {

        return $this->check->find($id);
    }
}
