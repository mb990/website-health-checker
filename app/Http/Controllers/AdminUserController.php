<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\CreateAdminRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all(AdminRequest $request) {

        $users = $this->userService->allPaginated(10);

        return view('admin.users.all')->with('users', $users);
    }

    public function activate(AdminRequest $request, $slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->activate($user);

        return redirect('/admin/users');
    }

    public function deactivate(AdminRequest $request, $slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->deactivate($user);

        return redirect('/admin/users');
    }

    public function destroy(AdminRequest $request, $slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->destroy($user);

        return redirect('/admin/users');
    }

    public function createAdmin(AdminRequest $request) {

        return view('admin.users.create-admin');
    }

    public function storeAdmin(CreateAdminRequest $request) {

        $admin = $this->userService->storeAdmin($request);

        $this->userService->assignRole($admin, 'admin');

        return redirect('/admin/users');
    }
}
