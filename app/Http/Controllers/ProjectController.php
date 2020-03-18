<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index() {

        $projects = $this->projectService->index();

        return view('projects.show-all')->with('projects', $projects);
    }

    public function show($slug) {

        $project = $this->projectService->read($slug);

        return view('projects.show-single')->with('project', $project);
    }

    public function create() {

        return view('projects.create');
    }

    public function store(ProjectRequest $request) {

        $attributes = $request->all();

        $this->projectService->store($attributes);

        return redirect('/');
    }

    public function edit($slug) {

        $project = $this->projectService->read($slug);
//        dd($project);

        return view('projects.edit')->with('project', $project);
    }

    public function update(ProjectRequest $request, $slug) {

        $attributes = $request->except('_method', '_token');

        $this->projectService->update($attributes, $slug);

        return redirect('/projects/' . $slug);
    }

    public function delete($slug) {

        $this->projectService->delete($slug);

        return redirect('/');
    }
}
