<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\ProjectService;
use App\Services\ProjectRoleService;
use Illuminate\Support\Facades\Auth;

class ProjectRequest extends FormRequest
{
    protected $projectService;
    protected $projectRoleService;

    public function __construct(ProjectService $projectService, ProjectRoleService $projectRoleService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->projectService = $projectService;
        $this->projectRoleService = $projectRoleService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {

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
            'name' => 'required',
        ];
    }

//    public function messages()
//    {
//        return[
//        ];
//    }
}
