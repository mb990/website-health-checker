<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class HttpService
{

    public function __construct()
    {
        //
    }

    public function get($url) {

        try {
            $response = Http::get($url);
            return $response;
        }
        catch (Exception $e) {
            return false;
        }
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
