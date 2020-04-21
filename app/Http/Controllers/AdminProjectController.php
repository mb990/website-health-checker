<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class AdminProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function all(AdminRequest $request) {

        $projects = $this->projectService->allPaginated(10);

        return view('admin.projects.all')->with('projects', $projects);
    }

    public function activate(AdminRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $this->projectService->activate($project);

        return redirect('/admin/projects');
    }

    public function deactivate(AdminRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $this->projectService->deactivate($project);

        return redirect('/admin/projects');
    }

    public function destroy(AdminRequest $request, $slug) {

        $project = $this->projectService->readBySlug($slug);

        $this->projectService->destroy($project);

        return redirect('/admin/projects');
    }
}
