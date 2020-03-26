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

    public function all() {

        return $this->projectUrl->all();
    }

    public function update($attributes, $id) {

        return $this->projectUrl->update($attributes, $id);
    }

    public function delete($id) {
//dd($id);
        return $this->projectUrl->delete($id);
    }

    public function shouldCheck($id) {

        return $this->projectUrl->shouldCheck($id);
    }
}
