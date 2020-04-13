<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class NotificationSettingRequest extends FormRequest
{
    protected $userService;

    public function __construct(UserService $userService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->userService = $userService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $loggedUser = auth()->user();

        $slug = Route::current()->parameter('slug');

        $user = $this->userService->findBySlug($slug);

        if ($loggedUser->id === $user->id) {

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
