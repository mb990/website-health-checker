<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUrlRequest;
use App\ProjectUrl;
use Illuminate\Http\Request;
use App\Services\ProjectUrlService;

class ProjectUrlController extends Controller
{
    protected $projectUrlService;

    public function __construct(ProjectUrlService $projectUrlService)
    {
        $this->projectUrlService = $projectUrlService;
    }

    public function store(ProjectUrlRequest $request, $slug) {

        $attributes = $request->all();

        $this->projectUrlService->store($attributes, $slug);

        return redirect()->back();
    }

    public function edit($id) {

        $url = $this->projectUrlService->read($id);
//dd($url);
        return view('projects.edit-url')->with('url', $url);
    }

    public function update(ProjectUrlRequest $request, $id) {

        $this->projectUrlService->update($request, $id);

        return redirect()->back();
    }

    public function delete($id) {
//dd($id);
        $this->projectUrlService->delete($id);

        return redirect()->back();
    }
}
