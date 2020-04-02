<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\ProjectService;
use App\Services\ProjectUrlService;
use App\Services\NotificationSettingService;
use App\Services\HttpService;
use App\Services\CheckService;
use App\Repositories\ProjectRepository;
use Carbon\Carbon;

class PageController extends Controller
{
    protected $projectService;
    protected $projectUrlService;
    protected $userService;
    protected $notificationSettingService;
    protected $projectRepository;
    protected $httpService;
    protected $checkService;

    public function __construct(ProjectService $projectService, UserService $userService, ProjectUrlService $projectUrlService,
                                NotificationSettingService $notificationSettingService, ProjectRepository $projectRepository,
                                HttpService $httpService, CheckService $checkService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
        $this->notificationSettingService = $notificationSettingService;
        $this->projectRepository = $projectRepository;
        $this->httpService = $httpService;
        $this->checkService = $checkService;
    }

    public function index() {

        return view('welcome');
    }

    public function dashboard() {

        $projects = auth()->user()->createdProjects;
//        dd($projects);
        return view('dashboard')->with('projects', $projects);
    }

    public function test() {

        $urls = $this->projectUrlService->all();

        foreach ($urls as $url) {

//            $response = $this->httpService->get($url->url);

//            $requestStart = Carbon::now();
            $response = $this->httpService->get('https://www.lynch.com/pariatur-rem-nihil-adipisci-omnis-cupiditate-dolor-dolorem');
//            $requestEnd = Carbon::now();

//            $responseTime = $this->checkService->measureResponseTime($requestStart, $requestEnd);

            dd($response);
        }

//        $notifications = $this->notificationSettingService->all();
//
//        foreach ($notifications as $setting) {
//
//            echo $setting->id . '<br>';
//        }



//        $project = $this->projectService->read('deangelo-bernier');
//
//            dd($this->projectService->usersToNotify($project)); // vraca kreatora minimum

        return view('test');
    }
}
