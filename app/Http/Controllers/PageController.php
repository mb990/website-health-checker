<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\NotificationTypeService;
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
    protected $notificationTypeService;

    public function __construct(ProjectService $projectService, UserService $userService, ProjectUrlService $projectUrlService,
                                NotificationSettingService $notificationSettingService, ProjectRepository $projectRepository,
                                HttpService $httpService, CheckService $checkService,
                                NotificationTypeService $notificationTypeService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
        $this->notificationSettingService = $notificationSettingService;
        $this->projectRepository = $projectRepository;
        $this->httpService = $httpService;
        $this->checkService = $checkService;
        $this->notificationTypeService = $notificationTypeService;
    }

    public function index() {

        return view('welcome');
    }

    public function dashboard(UserRequest $request) {

        $projects = auth()->user()->createdProjects;

        $joinedProjects = auth()->user()->memberInProjects;

        return view('dashboard')
            ->with('projects', $projects)
            ->with('joinedProjects', $joinedProjects);
    }

    // this method serves as a test method for various things
    public function test() {

//        $projects = $this->projectService->all();
//
//        $lastChecks = [];
//
//        $array = [];
//
//        foreach ($projects as $project) {
//
//            if (!$project->urls->isEmpty()) {
//
//                foreach ($project->urls as $url) {
//
////                    $check = $this->projectUrlService->createCheck($url);
//
//                    $lastCheck = $this->checkService->lastForUrl($url);
//
//                    if (!empty($lastCheck)) {
//
//                        $lastChecks[$project->slug][] = $lastCheck;
//                    }
//                }
//
//                if (!empty($lastChecks[$project->slug])) {
//
//                    foreach ($lastChecks[$project->slug] as $check) {
//
//                        if (!empty($check)) {
//
//                            if (!$this->httpService->requestSuccessful($check) && $this->projectService->isActive($url)) {
//
//                                $this->projectService->notifyMembers($url, 'url_down');
//                                $this->projectUrlService->setProjectDown($url->id);
//
//                            } else if (!$this->projectService->isActive($url) && $this->httpService->requestSuccessful($check)) {
//
//                                $array[] = $lastCheck;
//
//                                if (count($array) == count($lastChecks)) {
//
//                                    $this->projectService->notifyMembers($url, 'url_up');
//                                    $this->projectUrlService->setProjectUp($url->id);
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }

        return view('test');
    }
}
