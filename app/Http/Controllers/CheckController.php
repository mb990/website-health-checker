<?php

namespace App\Http\Controllers;

use App\Charts\ProjectUrlCheckChart;
use App\Services\CheckService;
use App\Services\ProjectUrlService;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    protected $checkService;
    protected $projectUrlService;

    public function __construct(CheckService $checkService, ProjectUrlService $projectUrlService)
    {
        $this->checkService = $checkService;
        $this->projectUrlService = $projectUrlService;
    }

    public function all($slug, $url) {
//dd($url);
        $chart = $this->projectUrlService->createUrlChart($url);
//dd($chart);
        $url = $this->projectUrlService->read($url);

        return view('projects.url-checks')
            ->with('url', $url)
            ->with('chart', $chart);
    }
}
