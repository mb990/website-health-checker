<?php


namespace App\Services;

use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\Repositories\ProjectRepository;
use App\Services\UserService;
use App\Services\ProjectUrlService;
use App\Services\NotificationSettingService;
use App\Services\HttpService;

class ProjectService
{
    protected $userService;
    protected $projectUrlService;
    protected $notificationSettingService;
    protected $httpService;

    public function __construct(ProjectRepository $project, UserService $userService, ProjectUrlService $projectUrlService,
                                NotificationSettingService $notificationSettingService, HttpService $httpService)
    {
        $this->project = $project;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
        $this->notificationSettingService = $notificationSettingService;
        $this->httpService = $httpService;
    }

    public function index() {

        return $this->project->all();
    }

    public function store($attributes) {
        $project = $this->project->store($attributes);

        $user = $this->userService->findById(auth()->user()->id);

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);
    }

    public function readBySlug($slug) {

        return $this->project->findBySlug($slug);
    }

    public function update($attributes, $slug) {

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }

    public function usersToNotify($slug) {

        $project = $this->readBySlug($slug);

        return $this->project->usersToNotify($project);
    }

    public function notificationDown($id) {

        $user = $this->userService->findById($id);

        $user->notify(new ProjectDownEmail());
    }

    public function notificationUp($id) {

        $user = $this->userService->findById($id);

        $type = 'url_up';

        if ($this->userService->hasNotification($user, $type)) {
            $user->notify(new ProjectUpEmail());
        }
    }

    public function setProjectDown($id) {

        $url = $this->projectUrlService->read($id);

        $this->project->setProjectDown($url);
    }

    public function setProjectUp($id) {

        $url = $this->projectUrlService->read($id);

        $this->project->setProjectUp($url);
    }

    public function isActive($id) {

        $url = $this->projectUrlService->read($id);

        $this->project->isActive($url);
    }

    public function notifyMembersProjectDown($url) {

        foreach ($this->usersToNotify($url->project->slug) as $user) {

            if ($this->userService->hasNotificationActive($user, 'url_down')) {

                $this->notificationDown($user->id);

            }
        }
    }

    public function notifyMembersProjectUp($url) {

        foreach ($this->usersToNotify($url->project->slug) as $user) {

            if ($this->userService->hasNotificationActive($user, 'url_up')) {

                $this->notificationUp($user->id);

            }
        }
    }
}
