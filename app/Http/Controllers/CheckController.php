<?php

namespace App\Http\Controllers;

use App\Services\CheckService;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    protected $checkService;

    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
    }

    public function all($slug, $url) {

        $checks = $this->checkService->allByTime($url);

        return view('projects.url-checks')->with('checks', $checks);
    }
}
