<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\NotificationSettingService;
use App\Services\RegisterService;

class UserService
{
    protected $notificationSettingService;
    protected $registerService;

    public function __construct(UserRepository $user, NotificationSettingService $notificationSettingService,
                                RegisterService $registerService)
    {
        $this->user = $user;
        $this->notificationSettingService = $notificationSettingService;
        $this->registerService = $registerService;
    }

    public function all() { // without admins

        $all = $this->user->all()->pluck('id')->toArray();

        $admins = $this->admins()->pluck('id')->toArray();

        $usersIds = array_diff($all, $admins);

        $withoutAdmins = [];

        foreach ($usersIds as $id) {

            $user = $this->findById($id);

            $withoutAdmins[] = $user;
        }

        return collect($withoutAdmins);
    }

    public function allPaginated($perPage) { // without admins

        return $this->user->allPaginated($perPage);
    }

    public function activeUsers() {

        return $this->user->activeUsers();
    }

    public function inactiveUsers() {

        return $this->user->inactiveUsers();
    }

    public function admins() {

        return $this->user->admins();
    }

    public function findById($id) {

        return $this->user->findById($id);
    }

    public function findBySlug($slug) {

        return $this->user->findBySlug($slug);
    }

    public function findByEmail($email) {

        return $this->user->findByEmail($email);
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

        $this->registerService->validateRegistration($request);

        $password = $this->registerService->hashPassword($request['password']);

        return $this->user->storeAdmin($request, $password);
    }
}
