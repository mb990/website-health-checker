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
//        {{dd($this->project->find($slug));}}

        return $this->project->find($slug);
    }

    public function update($attributes, $slug) {

        return $this->project->update($slug, $attributes);
    }

    public function delete($slug) {

        return $this->project->delete($slug);
    }

    public function notificationDown($id) {

        return $this->project->notificationDown($id);
    }

    public function notificationUp($id) {

        return $this->project->notificationUp($id);
    }

    public function setProjectDown($id) {

        return $this->project->setProjectDown($id);
    }

    public function setProjectUp($id) {

        return $this->project->setProjectUp($id);
    }

    public function active($id) {

        return $this->project->active($id);
    }
}
