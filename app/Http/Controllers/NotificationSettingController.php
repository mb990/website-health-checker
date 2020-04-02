<?php

namespace App\Http\Controllers;

use App\Services\NotificationSettingService;
use App\Services\UserService;
use App\Services\ProjectService;
use App\Http\Requests\NotificationSettingRequest;

class NotificationSettingController extends Controller
{
    protected $notificationSettingService;
    protected $userService;
    protected $projectService;

    public function __construct(NotificationSettingService $notificationSettingService,  UserService $userService,
                                ProjectService $projectService)
    {
        $this->notificationSettingService = $notificationSettingService;
        $this->userService = $userService;
        $this->projectService = $projectService;
    }

    public function all($slug) {

        $user = $this->userService->findBySlug($slug);

        $settings = $this->notificationSettingService->findByUser($user);

        return view('notification-settings.settings')->with('settings', $settings);
    }

    public function editSingleProject($slug) {

        $user = auth()->user();

        $project = $this->projectService->readBySlug($slug);

        $settings = $this->notificationSettingService->findByUserAndProject($user, $project);

        return view('projects.notification-settings')
            ->with('settings', $settings)
            ->with('project', $project);
    }

    public function updateSingleProject (NotificationSettingRequest $request, $slug) {


    }

    public function editAll($slug) {


    }

    public function updateAll(NotificationSettingRequest $request, $slug) {


    }
}
