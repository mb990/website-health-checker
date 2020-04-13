<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ProjectRoleService;
use App\Services\ProjectService;

class CheckIfInProject
{
    protected $projectRoleService;
    protected $projectService;

    public function __construct(ProjectRoleService $projectRoleService, ProjectService $projectService)
    {
        $this->projectRoleService = $projectRoleService;
        $this->projectService = $projectService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $slug)
    {
        $project = $this->projectService->readBySlug($slug);

        if ($this->projectRoleService->find($request->user(), $project)) {

            return $next($request);
        }

        return redirect('/');
    }
}
