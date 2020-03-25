<?php


namespace App\Repositories;

use App\Notifications\projectDownEmail;
use App\Project;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class ProjectRepository
{
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

//        return $this->project->create($attributes);
    }

    public function all() {

        return $this->project->paginate(10);
    }

    public function find($slug)
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
}
