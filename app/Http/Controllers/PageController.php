<?php

namespace App\Http\Controllers;

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

    public function dashboard() {

        $projects = auth()->user()->createdProjects;
//        dd($projects);
        return view('dashboard')->with('projects', $projects);
    }

    public function test() {

//        $setting = $this->notificationSettingService->findById(21);
//
//        $this->notificationSettingService->delete($setting);

//        dd($users);

        $url = $this->projectUrlService->read(2);

        $user = $this->userService->findById(1);

//        $active = $this->userService->hasNotificationActive($user, 'url_up');

        $active = $this->userService->hasNotificationActive($user, 'url_down', $url->project);

//        dd($active);

        return view('test');
    }
}
