<?php


namespace App\Services;

use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProjectUrlService;
use App\Services\NotificationSettingService;

class ProjectService
{
    protected $userService;
    protected $projectUrlService;
    protected $notificationSettingService;

    public function __construct(ProjectRepository $project, UserService $userService, ProjectUrlService $projectUrlService,
                                NotificationSettingService $notificationSettingService)
    {
        $this->project = $project;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
        $this->notificationSettingService = $notificationSettingService;
    }

    public function index() {

        return $this->project->all();
    }

    public function store($attributes) {
        $project = $this->project->store($attributes);

        $user = $this->userService->findById(auth()->user()->id);

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);

    }

    public function read($slug) {

        return $this->project->find($slug);
    }

    public function update($attributes, $slug) {

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }

    public function usersToNotify() {

        return $this->project->usersToNotify();
    }

    public function notificationDown($id) {

        $user = $this->userService->findById($id);

        $user->notify(new ProjectDownEmail());
    }

    public function notificationUp($id) {

        $user = $this->userService->findById($id);

        if ($this->userService->hasNotification($user)) {
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

    public function active($id) {

        $url = $this->projectUrlService->read($id);

        $this->project->active($url);
    }
}
