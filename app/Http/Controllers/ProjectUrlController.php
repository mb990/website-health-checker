<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUrlRequest;
use App\Services\ProjectUrlService;
use App\Services\FrequencyService;
use Illuminate\Support\Facades\Redirect;

class ProjectUrlController extends Controller
{
    protected $projectUrlService;
    protected $frequencyService;

    public function __construct(ProjectUrlService $projectUrlService, FrequencyService $frequencyService)
    {
        $this->projectUrlService = $projectUrlService;
        $this->frequencyService = $frequencyService;
    }

    public function store(ProjectUrlRequest $request, $slug) {

        $attributes = $request->all();

        $this->projectUrlService->store($attributes, $slug);

        return redirect()->back();
    }

    public function edit($slug, $id) {

        $url = $this->projectUrlService->read($id);

        $frequencies = $this->frequencyService->all();

        return view('projects.edit-url')
            ->with('url', $url)
            ->with('frequencies', $frequencies);
    }

    public function update(ProjectUrlRequest $request, $id) {

        $this->projectUrlService->update($request, $id);

        return Redirect::back();
    }

    public function delete($id)
    {
        $this->projectUrlService->delete($id);

        return redirect()->back();
    }
}
