<?php


namespace App\Services;

use App\Services\CheckService;

class HttpService
{
    protected $checkService;

    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
    }

    public function requestSuccessful($check) {

        if (in_array($check->response_code, range(200, 299))) {
            return true;
        }
        else {
            return false;
        }
    }
}
