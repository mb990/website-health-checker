<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\NotificationSettingService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $notificationSettingService;

    public function __construct(UserRepository $user, NotificationSettingService $notificationSettingService)
    {
        $this->user = $user;
        $this->notificationSettingService = $notificationSettingService;
    }

    public function all() {

        return $this->user->all();
    }

    public function allPaginated($perPage) {

        return $this->user->allPaginated($perPage);
    }

    public function findById($id) {

        return $this->user->findById($id);
    }

    public function findBySlug($slug) {

        return $this->user->findBySlug($slug);
    }

    public function activate($user) {

        return $this->user->activate($user);
    }

    public function deactivate($user) {

        return $this->user->deactivate($user);
    }

    public function destroy($user) {

        return $this->user->destroy($user);
    }

    public function checkIfActive($user) {

        if ($user->active) {
            return true;
        }
        return false;
    }

    public function hasNotificationActive($user, $typeName, $project)
    {

        $notification = $this->notificationSettingService->findByUserTypeAndProject($user, $typeName, $project);
//        dd($notification);

        if (isset($notification)) {
            if ($notification->active) {
                return true;
            }
        }

        return false;
    }

    public function assignRole($user, $role) {

        return $this->user->assignRole($user, $role);
    }

    public function storeAdmin($request) {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'string|required|min:8|confirmed',
        ]);

        $password = Hash::make($request['password']);

        return $this->user->storeAdmin($request, $password);
    }
}
