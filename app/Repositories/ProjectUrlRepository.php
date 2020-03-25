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
        $url->check_frequency_id = 5;

        $url->save();
    }

    public function find($id)
    {
        return $this->projectUrl->find($id);
    }

    public function update($attributes, $id) {
//        {{dd($attributes);}}
        $url = ProjectUrl::find($id);
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

//    public function checkStatus($id) {
//
//        $url = $this->projectUrl->find($id);
//
//        $lastCheck = $url->checks->latest()->first();
//
//        if ($lastCheck->response_code != range(200,299)) {
//            return $url;
//        }
//    }
}
