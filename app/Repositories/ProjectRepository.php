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

    public function all() {

        return $this->project->all();
    }

    public function allPaginated($perPage) {

        return $this->project->where('active', '=', 1)
            ->paginate($perPage);
    }

    public function store($attributes) {

        $project = new Project();

        $project->name = $attributes['name'];
        $project->user_id = auth()->user()->id;

        $project->save();

        return $project;
    }

    public function findBySlug($slug)
    {
        return $this->project->where('slug', '=', $slug)->first();
    }

    public function findById($id) {

        return $this->project->find($id);
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

    public function activate(Project $project) {

        $project->update(['active' => true]);
    }

    public function deactivate(Project $project) {

        $project->update(['active' => false]);
    }

    public function destroy(Project $project) {

        $project->forceDelete();
    }

    public function projectUsers($project) {

        $users = $project->members;

        $users[] = $project->creator;

        return $users;
    }

    public function addUserToProject($project, $user) {

        $project->members()->attach($user);
    }

    public function removeUserFromProject($project, $user) {

        $project->members()->detach($user);
    }
}
