<?php

namespace App\Http\Controllers;

use App\NotificationType;
use App\Services\NotificationSettingService;
use App\Services\UserService;
use App\Services\ProjectService;
use App\Services\NotificationTypeService;
use App\Http\Requests\NotificationSettingRequest;
use App\User;

class NotificationSettingController extends Controller
{
    protected $notificationSettingService;
    protected $userService;
    protected $projectService;
    protected $notificationTypeService;

    public function __construct(NotificationSettingService $notificationSettingService,  UserService $userService,
                                ProjectService $projectService, NotificationTypeService $notificationTypeService)
    {
        $this->notificationSettingService = $notificationSettingService;
        $this->userService = $userService;
        $this->projectService = $projectService;
        $this->notificationTypeService = $notificationTypeService;
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

        $project = $this->projectService->readBySlug($slug);

        $settings = $this->notificationSettingService->findByProject($project);

        $this->notificationSettingService->updateSingleProject($request, $settings);

        return redirect('/projects/' . $slug . '/settings');
    }

    public function editGlobal($slug) {

        $user = $this->userService->findBySlug($slug);

        $settings = $this->notificationSettingService->editGlobal($user);

        return view('notification-settings.settings')
            ->with('settings', $settings)
            ->with('user', $user);
    }

    public function updateGlobal(NotificationSettingRequest $request, $slug) {

        $user = $this->userService->findBySlug($slug);

        $types = $this->notificationTypeService->all();

        foreach ($types as $type) {

            $notificationSettings = $this->notificationSettingService->findByUserAndType($user, $type->name);

            $this->notificationSettingService->updateSingleProject($request, $notificationSettings);
        }

//        $globalSettings = $user->notificationTypes;
//
//        foreach ($globalSettings as $globalSetting) {
//
//            $this->notificationSettingService;
//        }
    }
}
