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

        $users = $this->projectService->usersNotInProject($project);
//dd($users);
        return view('teams.invite')
            ->with('project', $project)
            ->with('users', $users);
    }

    public function process(Request $request, $slug) {

        $this->inviteService->process($request, $slug);

        return redirect('/projects/' . $slug);
    }

    public function view($token) {

        $this->inviteService->view($token);

        return view('teams.view-invitation');
    }
}
