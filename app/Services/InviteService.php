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

    public function process(Request $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $userId = $request->input('user');

        $user = $this->userService->findById($userId);

        $projectInvitationData = $this->defineData($project, $user);

        $token = $this->generateToken();

        $this->invite->store($token, $projectInvitationData['recipientEmail']);

        Mail::to($projectInvitationData['recipientEmail'])->send(new InviteCreated($projectInvitationData));

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
//            'projectSlug' => $project->slug,
            'recipientEmail' => $user->email,
            'recipientName' => ucfirst($user->first_name) . ' ' . ucfirst($user->last_name)
        ];

        return $data;
    }

    public function view($token, $project) {

        if(!$this->invite->findByToken($token)) {

            abort(404);
        }

        $this->projectService->addUserToProject($project, $user);

        $this->notificationSettingService->subscribeUserToNotifications($user, $project);
    }
}
