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

    public function getResponseCode($response) {

        if ($response) {
            $responseCode = $response->status();
        }
        else {
            $responseCode = 0;
        }

        return $responseCode;
    }

    public function measureResponseTime($requestStart, $requestEnd) {

        $responseTime = $requestEnd->diffInMilliseconds($requestStart) / 1000;

        return $responseTime;
    }
}
