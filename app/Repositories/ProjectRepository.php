<?php


namespace App\Repositories;

use App\Project;
use App\User;
use Illuminate\Notifications\Notifiable;

class ProjectRepository
{
    use Notifiable;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function store($attributes) {

        $project = new Project();

        $project->name = $attributes['name'];
        $project->user_id = auth()->user()->id;

        $project->save();

        return $project;
    }

    public function all() {

        return $this->project->paginate(10);
    }

    public function findBySlug($slug)
    {
        return $this->project->where('slug', '=', $slug)->first();
    }

    public function update($slug, array $attributes) {

        $project = $this->project->where('slug', '=', $slug)->first();

        $project->slug = null;
        $project->save();

        return $project->update($attributes);
    }

    public function delete($slug) {

        return $this->project->where('slug', '=', $slug)->delete();
    }

    public function projectUsers($project) {

        $users = $project->members;

        $users[] = $project->creator;

        return $users;
    }

    public function setProjectDown($url) {

        $url->project->up = 0;

        $url->project->save();
    }

    public function setProjectUp($url) {

        $url->project->up = 1;

        $url->project->save();
    }
}
