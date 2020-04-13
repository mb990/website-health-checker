<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageProjectRequest;
use App\Http\Requests\ViewProjectRequest;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Http\Requests\ProjectRequest;
use Illuminate\Notifications\Notifiable;

class ProjectController extends Controller
{

    use Notifiable;

    protected $projectService;
    protected $userService;

    public function __construct(ProjectService $projectService, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
    }

    public function all() {

        $projects = $this->projectService->allPaginated(10);

        return view('projects.show-all')->with('projects', $projects);
    }

    public function show(ViewProjectRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        return view('projects.show-single')->with('project', $project);
    }

    public function create(ManageProjectRequest $request) {

        return view('projects.create');
    }

    public function store(ProjectRequest $request) {

        $attributes = $request->all();

        $this->projectService->store($attributes);

        return redirect('/');
    }

    public function edit(ManageProjectRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        return view('projects.edit')->with('project', $project);
    }

    public function update(ProjectRequest $request, $slug) {

        $attributes = $request->except('_method', '_token');

        $this->projectService->update($attributes, $slug);

        return redirect('/projects');
    }

    public function delete(ManageProjectRequest $request, $slug) {

        $this->projectService->delete($slug);

        return redirect('/projects');
    }

    public function members(ManageProjectRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $members = $this->projectService->projectUsers($project);

        return view('teams.project-members')
            ->with('project', $project)
            ->with('members', $members);
    }

    public function removeMember(ManageProjectRequest $request, $projectSlug, $userSlug) {

        $project = $this->projectService->readBySlug($projectSlug);

        $user = $this->userService->findBySlug($userSlug);

        $this->projectService->removeUserFromProject($project, $user);

        return redirect('/projects/' . $projectSlug . '/members');
    }
}
