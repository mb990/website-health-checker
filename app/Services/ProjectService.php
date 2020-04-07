<?php


namespace App\Services;

use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProjectUrlService;
use App\Services\NotificationSettingService;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Collection;

class ProjectService
{
    use Notifiable;

    protected $userService;
    protected $projectUrlService;
    protected $notificationSettingService;
    protected $project;

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

    public function readBySlug($slug) {

        return $this->project->findBySlug($slug);
    }

    public function update($attributes, $slug) {

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }

    public function projectUsers($project) {

        return $this->project->projectUsers($project);
    }

    public function usersNotInProject($project) {

        $allUsers = $this->userService->all()->pluck('id')->toArray();

        $projectUsers = $this->projectUsers($project)->pluck('id')->toArray();

        $usersIds = array_diff($allUsers, $projectUsers);

        $users = [];

        foreach ($usersIds as $id) {

            $user = $this->userService->findById($id);

            $users[] = $user;
        }

//        $users = collect($users);

        return $users;
    }

    public function usersToNotify($project) {

        return $this->projectUsers($project);
    }

    public function notificationDown($user) {

        $user->notify(new ProjectDownEmail());
    }

    public function notificationUp($user) {

        $user->notify(new ProjectUpEmail());
    }

    public function notifyMembersProjectDown($url) {

        foreach ($this->usersToNotify($url->project) as $user) {

            if ($this->userService->hasNotificationActive($user, 'url_down')) {

                $this->notificationDown($user);

            }
        }
    }

    public function notifyMembersProjectUp($url) {

        foreach ($this->usersToNotify($url->project) as $user) {

            if ($this->userService->hasNotificationActive($user, 'url_up')) {

                $this->notificationUp($user);

            }
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

    public function isActive($url) {

        if ($url->project->up == 1) {
            return true;
        }

        return false;
    }
}
