<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\ProjectRoleService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Route;

class ManageProjectRequest extends FormRequest
{
    protected $projectRoleService;
    protected $projectService;

    public function __construct(ProjectRoleService $projectRoleService, ProjectService $projectService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->projectRoleService = $projectRoleService;
        $this->projectService = $projectService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $slug = Route::current()->parameter('slug');

        $user = auth()->user();

        $project = $this->projectService->readBySlug($slug);

        if ($this->projectRoleService->hasRole($user, $project ,'creator') && $project->active == 1) {

            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
