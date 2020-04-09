<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\InviteService;
use App\Services\UserService;

class InviteController extends Controller
{

    protected $projectService;
    protected $inviteService;
    protected $userService;

    public function __construct(ProjectService $projectService, InviteService $inviteService, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->inviteService = $inviteService;
        $this->userService = $userService;
    }

    public function invite($slug) {

        $project = $this->projectService->readBySlug($slug);

        $users = $this->inviteService->invitableUsers($project);

        return view('teams.invite')
            ->with('project', $project)
            ->with('users', $users);
    }

    public function process(Request $request, $slug) {

        $this->inviteService->process($request, $slug);

        return redirect('/projects/' . $slug);
    }

    public function view($projectSlug, $userSlug, $token) {

        $project = $this->projectService->readBySlug($projectSlug);

        $user = $this->userService->findBySlug($userSlug);

        $this->inviteService->ifTokenExists($token);

        return view('teams.view-invitation')
            ->with('token', $token)
            ->with('user', $user)
            ->with('project', $project);
    }

    public function accept($projectSlug, $userSlug, $token) {

        $project = $this->projectService->readBySlug($projectSlug);

        $user = $this->userService->findBySlug($userSlug);

        $this->inviteService->accept($project, $user, $token);

        return view('teams.accepted-invitation')
            ->with('project', $project);
    }

    public function reject($token) {

        $this->inviteService->reject($token);

        return redirect('/dashboard');
    }
}
