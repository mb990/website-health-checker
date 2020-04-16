<?php


namespace App\Repositories;

use App\Check;
use App\ProjectUrl;
use App\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Exception;

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
        $url->check_frequency_id = 5;

        $url->save();
    }

    public function find($id)
    {
        return $this->projectUrl->find($id);
    }

    public function all() {

        return $this->projectUrl->all();
    }

    public function update($attributes, $id) {

        $url = $this->find($id);

        return $url->update(['check_frequency_id' => intval($attributes['check_frequency_id'])]);
    }

    public function delete($id) {

        return $this->projectUrl->find($id)->delete();
    }

    public function createCheck($url, $responseTime, $responseCode, $lastCheckedAt)
    {
        $check = new Check();

        $check->response_time = $responseTime;
        $check->response_code = $responseCode;
        $check->url_id = $url->id;

        $url->last_checked_at = $lastCheckedAt;

        $url->save();
        $check->save();

        return $check;
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
