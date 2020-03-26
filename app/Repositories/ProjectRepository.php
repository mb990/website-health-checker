<?php


namespace App\Repositories;

use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\Project;
use App\Services\UserService;
use App\Services\ProjectUrlService;
use Illuminate\Notifications\Notifiable;

class ProjectRepository
{
    use Notifiable;

    protected $project;
    protected $userService;
    protected $projectUrlService;

    public function __construct(Project $project, UserService $userService, ProjectUrlService $projectUrlService)
    {
        $this->project = $project;
        $this->userService = $userService;
        $this->projectUrlService = $projectUrlService;
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

    public function notificationDown($id) {

        $user = $this->userService->find($id);

        $user->notify(new ProjectDownEmail());
    }

    public function setProjectDown($id) {

        $url = $this->projectUrlService->read($id);

        $url->project->up = 0;

        $url->project->save();
    }

    public function notificationUp($id) {

        $user = $this->userService->find($id);

        $user->notify(new ProjectUpEmail());
    }

    public function setProjectUp($id) {

        $url = $this->projectUrlService->read($id);

        $url->project->up = 1;

        $url->project->save();
    }

    public function active($id) {

        $url = $this->projectUrlService->read($id);

        if ($url->project->up == 1) {
            return true;
        }
        else {
            return false;
        }
    }
}
