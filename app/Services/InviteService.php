<?php


namespace App\Services;

use App\Repositories\InviteRepository;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Services\NotificationSettingService;
use App\Mail\InviteCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InviteService
{
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

    public function checkForDeletion() {

        $invites = $this->all();

        $time = Carbon::now()->subDays(5);

        return $this->invite->checkForDeletion($invites, $time);
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

            $invitableUsers[] = $user;
        }

        return $invitableUsers;
    }

    public function process(Request $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $userId = $request->input('user');

        $user = $this->userService->findById($userId);

        $projectInvitationData = $this->defineData($project, $user);

        $token = $this->generateToken();

        $projectInvitationData['token'] = $token;

        $this->store($user, $project, $token);

        Mail::to($user->email)->send(new InviteCreated($projectInvitationData));

        return $projectInvitationData;
    }

    public function generateToken() {

        do {
            $token = Str::random(32);
        }
        while ($this->invite->findByToken($token));

        return $token;
    }

    public function defineData($project, $user) {

        $data = [
            'senderEmail' => $project->creator->email,
            'senderName' => ucfirst($project->creator->first_name) . ' ' . ucfirst($project->creator->last_name),
            'projectName' => $project->name,
            'projectSlug' => $project->slug,
            'recipientEmail' => $user->email,
            'recipientName' => ucfirst($user->first_name) . ' ' . ucfirst($user->last_name),
            'recipientSlug' => $user->slug,
            'recipientId' => $user->id
        ];

        return $data;
    }

    public function ifTokenExists($token) {

        if(!$this->findByToken($token)) {

            abort(404);
        }
    }

    public function accept($project, $user, $token) {

        $this->projectService->addUserToProject($project, $user);

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);

        $this->delete($token);
    }

    public function reject($token) {

        $this->delete($token);
    }
}
