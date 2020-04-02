<?php


namespace App\Services;


use App\Repositories\CheckRepository;
use Exception;

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

        try {
            $responseCode = $response->status();
        } catch (Exception $e) {
            $responseCode = 0;
        }

        return $responseCode;
    }

    public function measureResponseTime($requestStart, $requestEnd) {

        $responseTime = $requestEnd->diffInMilliseconds($requestStart);

        return $responseTime;
    }
}
