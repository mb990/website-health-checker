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

    public function allByTime($url) {

        return $this->check->latest()
            ->where('url_id', '=', $url)
            ->get();
    }

    public function find($id) {

        return $this->check->find($id);
    }

    public function successful($id) {

        $check = $this->check->find($id);

        if (in_array($check->response_code, range(200, 299))) {
            return true;
        }
        else {
            return false;
        }
    }
}
