<?php


namespace App\Repositories;

use App\ProjectUrl;
use App\Project;

class ProjectUrlRepository
{
    protected $projectUrl;

    public function __construct(ProjectUrl $projectUrl)
    {
        $this->projectUrl = $projectUrl;
    }

    public function store($attributes, $slug) {

        $project = Project::where('slug', '=', $slug)->first();

        $url = new ProjectUrl();

        $url->url = $attributes['url'];
        $url->project_id = $project->id;

        $url->save();
    }

    public function find($id)
    {
//        dd($id);
        return $this->projectUrl->find($id);
    }

    public function update(array $attributes, $id) {

        $url = ProjectUrl::find($id);

        return $url->update($attributes);
    }

    public function delete($id) {

        return $this->projectUrl->find($id)->delete();
    }
}
