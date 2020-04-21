<?php


namespace App\Services;

use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\Notifications\MemberJoinedProject;
use App\Notifications\MemberLeftProject;
use App\Notifications\ShareProject;
use App\Project;
use App\ProjectUrl;
use App\Repositories\ProjectRepository;
use App\Services\UserService;
use App\Services\NotificationSettingService;
use App\Services\ProjectRoleService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use phpDocumentor\Reflection\Types\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

class ProjectService
{
    use Notifiable;

    protected $userService;
    protected $notificationSettingService;
    protected $project;
    protected $projectRole;

    public function __construct(ProjectRepository $project, UserService $userService,
                                NotificationSettingService $notificationSettingService, ProjectRoleService $projectRole)
    {
        $this->project = $project;
        $this->userService = $userService;
        $this->notificationSettingService = $notificationSettingService;
        $this->projectRole = $projectRole;
    }

    public function all() {

        return $this->project->all();
    }

    public function allPaginated($perPage) {

        return $this->project->allPaginated($perPage);
    }

    public function store($attributes) {

        $project = $this->project->store($attributes);

        $user = $this->userService->findById(auth()->user()->id);

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);

        $this->projectRole->assignProjectRole($user, $project, 'creator');
    }

    public function readBySlug($slug) {

        return $this->project->findBySlug($slug);
    }

    public function readById($id) {

        return $this->project->findById($id);
    }

    public function update($attributes, $slug) {

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }

    public function activate($project) {

        return $this->project->activate($project);
    }

    public function deactivate($project) {

        return $this->project->deactivate($project);
    }

    public function destroy($project) {

        return $this->project->destroy($project);
    }

    public function isUserInProject($user, $project) {

        $users = $project->members;

        if(in_array($user, $users)) {

            return true;
        }

        return false;
    }

    public function projectUsers($project)
    {

        $projectUsers = $this->project->projectUsers($project)->pluck('id')->toArray();

        $inactiveUsers = $this->userService->inactiveUsers()->pluck('id')->toArray();

        $usersIds = array_diff($projectUsers, $inactiveUsers);

        $users = [];

        foreach ($usersIds as $id) {

            $user = $this->userService->findById($id);

            $users[] = $user;
        }

        return collect($users);
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

        return $users;
    }

    public function usersToNotify($project) {

        return $this->projectUsers($project);
    }

    public function addUserToProject($project, $user) {

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);

        $this->projectRole->assignProjectRole($user, $project, 'viewer');

        $this->project->addUserToProject($project, $user);

        $this->notifyMembers($project, 'member_joined_team');
    }

    public function removeUserFromProject($project, $user) {

        $this->project->removeUserFromProject($project, $user);

        $this->notificationSettingService->unsubscribeUserFromNotifications($user, $project);

        $this->projectRole->removeProjectRole($user, $project);

        $this->notifyMembers($project, 'member_left_team');
    }

    public function notificationDown($user) {

        $user->notify(new ProjectDownEmail());
    }

    public function notificationUp($user) {

        $user->notify(new ProjectUpEmail());
    }

    public function notificationJoinedTeam($user, $project) {

        $user->notify(new MemberJoinedProject($project));
    }

    public function notificationLeftTeam($user, $project) {

        $user->notify(new MemberLeftProject($project));
    }

    public function notifyMembers($data, $type)
    {

        if ($data instanceof ProjectUrl) {

            foreach ($this->usersToNotify($data->project) as $user) {

                if ($type == 'url_down') {

                    if ($this->userService->hasNotificationActive($user, $type, $data->project)) {

                        $this->notificationDown($user);

                    }
                } else if ($type == 'url_up') {

                    if ($this->userService->hasNotificationActive($user, $type, $data->project)) {

                        $this->notificationUp($user);
                    }
                }
            }
        }

        if ($data instanceof Project) {

            foreach ($this->usersToNotify($data) as $user) {

                if ($type == 'member_joined_team') {

                    if ($this->userService->hasNotificationActive($user, $type, $data)) {

                        $this->notificationJoinedTeam($user, $data);
                    }
                }

                else if ($type == 'member_left_team') {

                    if ($this->userService->hasNotificationActive($user, $type, $data)) {

                        $this->notificationLeftTeam($user, $data);
                    }
                }
            }
        }

        }

    public function isActive($url) {

        if ($url->project->up == 1) {
            return true;
        }

        return false;
    }

    public function generatePublicLink($project) {

        $hash = Crypt::encrypt($project->slug);

        $publicLink = \url('/projects/public/' . $hash);

        return $publicLink;
    }

    public function shareProject($project, $email) {

        $publicLink = $this->generatePublicLink($project);

        Notification::route('mail', $email)->notify(new ShareProject($publicLink));
    }
}
