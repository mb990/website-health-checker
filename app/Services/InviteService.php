<?php


namespace App\Services;

use App\Repositories\InviteRepository;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Services\NotificationSettingService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CreatedInvite;
use App\Notifications\CreatedGuestInvite;
use Illuminate\Support\Facades\Notification;

class InviteService
{
    use Notifiable;

    protected $invite;
    protected $projectService;
    protected $userService;
    protected $notificationSettingService;

    public function __construct(InviteRepository $invite, ProjectService $projectService, UserService $userService,
                                NotificationSettingService $notificationSettingService)
    {
        $this->invite = $invite;
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->notificationSettingService = $notificationSettingService;
    }

    public function all() {

        return $this->invite->all();
    }

    public function store($user, $project, $token) {

        return $this->invite->store($user, $project, $token);
    }

    public function delete($token) {

        return $this->invite->delete($token);
    }

    public function findByToken($token) {

        return $this->invite->findByToken($token);
    }

    public function findByProject($project) {

        return $this->invite->findByProject($project);
    }

    public function findByEmail($email) {

        return $this->invite->findByEmail($email);
    }

    public function deleteExpired() {

        $time = Carbon::now()->subDays(5);

        return $this->invite->deleteExpired($time);
    }

    public function invitedUsers($project) {

        $invites = $this->findByProject($project)->pluck('user_id')->toArray();

        $users = [];

        foreach ($invites as $invite) {

            $user = $this->userService->findById($invite);

            $users[] = $user;
        }

//        $users = collect($users);

        return $users;
    }

    public function invitableUsers($project) {

        $usersNotInProject = $this->projectService->usersNotInProject($project);

        $invitedUsers = $this->invitedUsers($project);

        $usersIds = array_diff($usersNotInProject, $invitedUsers);

        $invitableUsers = [];

        foreach ($usersIds as $id) {

            $user = $this->userService->findById($id['id']);

            if ($this->userService->checkIfActive($user)) {

                $invitableUsers[] = $user;

            }
        }

        return $invitableUsers;
    }

    public function process(Request $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        if (!$this->checkIfGuest($request)) {

            $userId = $request->input('user');

            $user = $this->userService->findById($userId);

            $projectInvitationData = $this->defineData($project, $user);

            $this->store($user->email, $project, $projectInvitationData['token']);

            $user->notify(new CreatedInvite($projectInvitationData));

            return true;
        }

        $email = $request->input('guest');

        if (!$this->userService->findByEmail($email)) { // check if there is already user with given email

            if (!$this->checkIfGuestInvited($email)) {

                $projectInvitationData = $this->defineData($project, $email);

                $this->store($email, $project, $projectInvitationData['token']);

                Notification::route('mail', $email)->notify(new CreatedGuestInvite($projectInvitationData));

                return true;
            }

        }

        return false;
    }

    public function checkIfGuest(Request $request) {

        if ($request->input('user') == null) {

            return true;
        }

        return false;
    }

    public function checkIfGuestInvited($email) {

        if ($invite = $this->findByEmail($email)) {

            return true;
        }

        return false;
    }

    public function generateToken() {

        do {
            $token = Str::random(32);
        }
        while ($this->invite->findByToken($token));

        return $token;
    }

    public function defineData($project, $user) {

        $token = $this->generateToken();

        $data = [
            'senderEmail' => $project->creator->email,
            'senderName' => ucfirst($project->creator->first_name) . ' ' . ucfirst($project->creator->last_name),
            'projectName' => $project->name,
            'projectSlug' => $project->slug,
            'token' => $token
        ];

        if ($user instanceof User) {

            $data['recipientEmail'] = $user->email;
            $data['recipientName'] = ucfirst($user->first_name) . ' ' . ucfirst($user->last_name);
            $data['recipientSlug'] = $user->slug;
            $data['recipientId'] = $user->id;
        }
        else {

            $data['recipientEmail'] = $user;
        }

        return $data;
    }

    public function ifTokenExists($token) {

        if(!$this->findByToken($token)) {

            abort(404);
        }
    }

    public function accept($project, $user, $token) {

        $this->projectService->addUserToProject($project, $user);

        $this->delete($token);
    }

    public function reject($token) {

        $this->delete($token);
    }
}
