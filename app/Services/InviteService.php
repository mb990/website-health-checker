<?php


namespace App\Services;

use App\Services\ProjectService;
use App\Services\UserService;
use App\Mail\InviteCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InviteService
{
    protected $projectService;
    protected $userService;

    public function __construct(ProjectService $projectService, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
    }

    public function process(Request $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $userId = $request->input('user');

        $user = $this->userService->findById($userId);

        $data = [
            'senderEmail' => $project->creator->email,
            'senderName' => ucfirst($project->creator->first_name) . ' ' . ucfirst($project->creator->last_name),
            'project' => $project->name,
            'to' => $user->email
        ];

        Mail::to($data['to'])->send(new InviteCreated($data));

        return $data;
    }
}
