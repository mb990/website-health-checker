<?php


namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectService
{
    public function __construct(ProjectRepository $project)
    {
        $this->project = $project;
    }

    public function index() {

        return $this->project->all();
    }

    public function store($attributes) {

        return $this->project->store($attributes);
    }

    public function read($slug) {

        return $this->project->find($slug);
    }

    public function update(Request $request, $slug) {

        $attributes = $request->all();

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }
}
