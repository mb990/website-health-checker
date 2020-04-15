<?php


namespace App\Services;

use App\Charts\ProjectUrlCheckChart;
use App\Repositories\ProjectUrlRepository;
use App\Services\HttpService;
use App\Services\CheckService;
use App\Services\ProjectService;
use Carbon\Carbon;

class ProjectUrlService
{
    protected $httpService;
    protected $checkService;
    protected $projectService;

    public function __construct(ProjectUrlRepository $projectUrl, HttpService $httpService, CheckService $checkService,
                                ProjectService $projectService)
    {
        $this->projectUrl = $projectUrl;
        $this->httpService = $httpService;
        $this->checkService = $checkService;
        $this->projectService = $projectService;
    }

    public function store($attributes, $slug) {

        return $this->projectUrl->store($attributes, $slug);
    }

    public function read($id) {

        return $this->projectUrl->find($id);
    }

    public function all() {

        return $this->projectUrl->all();
    }

    public function update($attributes, $id) {

        return $this->projectUrl->update($attributes, $id);
    }

    public function delete($id) {
//dd($id);
        return $this->projectUrl->delete($id);
    }

    public function createUrlChart($url, $value) {

        $checks = $this->checkService->allByTime($url)->pluck($value, 'created_at');

        $timestamps = $checks->keys();

        $chart = new ProjectUrlCheckChart();

        $chart->labels($timestamps);

        if ($value == 'response_code') {

            $values = $checks->values();

            $chart->labels(['success', 'error']);

            $success = [];

            $error = [];

            foreach ($values as $value) {

                if (in_array($value, range(200, 299))) {

                    $success[] = $value;
                }

                else {

                    $error[] = $value;
                }
            }

            $success = count($success);

            $error = count($error);

            $chart->dataset('URL health', 'pie', [$success, $error])->backgroundColor(['red', 'blue']);

            return $chart;
        }

        $values = $checks->values();

        $chart->dataset('URL response times in seconds', 'line', $values);

        return $chart;
    }

    public function shouldCheck($url) {

        if($url->last_checked_at == null) {

            return true;
        }

        if (Carbon::now()->diffInSeconds($url->last_checked_at) > $url->checkFrequency->value) {
            return true;
        }
        else {
            return false;
        }
    }

    public function createCheck($url) {

        if ($this->shouldCheck($url)) {

            $requestStart = Carbon::now();
            $response = $this->httpService->get($url->url);
            $requestEnd = Carbon::now();

            $responseTime = $this->checkService->measureResponseTime($requestStart, $requestEnd);

            $responseCode = $this->checkService->getResponseCode($response);

            $lastCheckedAt = Carbon::now();

            return $this->projectUrl->createCheck($url, $responseTime, $responseCode, $lastCheckedAt);

        }
    }

    public function checkUrl() {

        $urls = $this->all();

        foreach ($urls as $url) {

            $check = $this->createCheck($url);

            if (!$this->httpService->requestSuccessful($check) && $this->projectService->isActive($url)) {

                $this->projectService->notifyMembersProjectDown($url);
                $this->setProjectDown($url->id);

            }

            else if(!$this->projectService->isActive($url) && $this->httpService->requestSuccessful($check)) {

                $this->projectService->notifyMembersProjectUp($url);
                $this->setProjectUp($url->id);
            }
        }
    }

    public function setProjectDown($id) {

        $url = $this->read($id);

        $this->projectUrl->setProjectDown($url);
    }

    public function setProjectUp($id) {

        $url = $this->read($id);

        $this->projectUrl->setProjectUp($url);
    }
}
