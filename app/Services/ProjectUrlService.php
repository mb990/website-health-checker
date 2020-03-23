<?php


namespace App\Services;

use App\Repositories\ProjectUrlRepository;

class ProjectUrlService
{
    public function __construct(ProjectUrlRepository $projectUrl)
    {
        $this->projectUrl = $projectUrl;
    }

    public function store($attributes, $slug) {

        return $this->projectUrl->store($attributes, $slug);
    }

    public function read($id) {

        return $this->projectUrl->find($id);
    }

    public function update($attributes, $id) {

        return $this->projectUrl->update($attributes, $id);
    }

    public function delete($id) {
//dd($id);
        return $this->projectUrl->delete($id);
    }

    public function status($id) {

        return $this->projectUrl->status($id);
    }

//    public function statusDown($id) {
//
//        return $this->projectUrl->statusDown($id);
//    }
}
