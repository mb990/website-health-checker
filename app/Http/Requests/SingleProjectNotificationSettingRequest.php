<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Services\ProjectService;
use App\Services\NotificationSettingService;

class SingleProjectNotificationSettingRequest extends FormRequest
{
    protected $projectService;
    protected $notificationSettingService;

    public function __construct(ProjectService $projectService, NotificationSettingService $notificationSettingService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->projectService = $projectService;
        $this->notificationSettingService = $notificationSettingService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        $slug = Route::current()->parameter('slug');

        $project = $this->projectService->readBySlug($slug);

        if ($this->notificationSettingService->findByUserAndProject($user, $project)) {

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
