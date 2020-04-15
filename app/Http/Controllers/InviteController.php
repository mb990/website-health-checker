<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageProjectRequest;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\InviteService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

    public function invite(ManageProjectRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $users = $this->inviteService->invitableUsers($project);

        return view('teams.invite')
            ->with('project', $project)
            ->with('users', $users);
    }

    public function process(ManageProjectRequest $request, $slug) {

        if ($this->inviteService->process($request, $slug)) {

            return redirect('/projects/' . $slug)
                ->with('success', 'User is invited to your team. Please wait for response.');
        }

        return Redirect::back()
            ->withErrors(['Something went wrong.', 'The Message']);
    }

    public function view($token) {

        $this->inviteService->ifTokenExists($token);

        $invite = $this->inviteService->findByToken($token);

        $project = $this->projectService->readById($invite->project_id);

        $user = $this->userService->findByEmail($invite->email);

        return view('teams.view-invitation')
            ->with('token', $token)
            ->with('user', $user)
            ->with('project', $project);
    }

    public function accept($token) {

        $invite = $this->inviteService->findByToken($token);

        $project = $this->projectService->readById($invite->project_id);

        $user = $this->userService->findByEmail($invite->email);

        $this->inviteService->accept($project, $user, $token);

        return view('teams.accepted-invitation')
            ->with('project', $project);
    }

    public function reject($token) {

        $this->inviteService->reject($token);

        if (Auth::check()) {

            return redirect('/dashboard');
        }

        return redirect('/');
    }

    public function viewGuest($token) {

        $this->inviteService->ifTokenExists($token);

        $invite = $this->inviteService->findByToken($token);

        $project = $this->projectService->readById($invite->project_id);

        return view('teams.view-invitation')
            ->with('token', $token)
            ->with('project', $project);
    }

    public function acceptGuest($token) {

        return redirect('/register/' . $token);
    }
}
