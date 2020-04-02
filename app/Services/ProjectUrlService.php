<?php


namespace App\Services;

use App\Repositories\ProjectUrlRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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

    public function shouldCheck($url) {

        if (Carbon::now()->diffInSeconds($url->last_checked_at) > $url->checkFrequency->value) {
            return true;
        }
        else {
            return false;
        }
    }

    public function createCheck($url) {

        if ($this->shouldCheck($url)) {

            return $this->projectUrl->createCheck($url);
        }
    }
}
