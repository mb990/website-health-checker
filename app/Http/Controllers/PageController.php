<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\ProjectService;
use App\Services\ProjectUrlService;
use App\Services\NotificationSettingService;
use App\Repositories\ProjectRepository;

class PageController extends Controller
{
    protected $projectService;
    protected $projectUrlService;
    protected $userService;
    protected $notificationSettingService;
    protected $projectRepository;

    public function __construct(ProjectService $projectService, UserService $userService, ProjectUrlService $projectUrlService,
                                NotificationSettingService $notificationSettingService, ProjectRepository $projectRepository)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
        $this->notificationSettingService = $notificationSettingService;
        $this->projectRepository = $projectRepository;
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

            $check = $this->projectUrlService->createCheck($url);

            dd($check->id);

//            dd($check['id']);

//            dd($url->project);

//            $notification = $this->notificationSettingService->findByUserAndType($url->project->creator, 'url_down');
//
//            dd($notification);  // vraca setting

//            $this->userService->hasNotificationActive($url->project->creator, 'url_down'); // okej

//            dd($this->projectService->isActive($url)); // radi
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
