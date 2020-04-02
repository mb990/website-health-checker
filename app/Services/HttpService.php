<?php


namespace App\Services;

use App\Services\CheckService;
use Illuminate\Support\Facades\Http;

class HttpService
{
    protected $checkService;

    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
    }

    public function get($url) {

        return Http::get($url);
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
