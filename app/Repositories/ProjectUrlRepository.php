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
//        {{dd($attributes);}}
        $url = $this->find($id);
//        dd($url);
//        $arrAttributes = $attributes->toArray();
//        dd($arrAttributes['check_frequency_id']);
//        $url->check_frequency = $attributes['check_frequency'];

//        $url->save();

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
}
