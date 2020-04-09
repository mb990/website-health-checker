<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all() {

        $users = $this->userService->allPaginated(10);

        return view('admin.users.all')->with('users', $users);
    }

    public function activate($slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->activate($user);

        return redirect('/admin/users');
    }

    public function deactivate($slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->deactivate($user);

        return redirect('/admin/users');
    }

    public function destroy($slug) {

        $user = $this->userService->findBySlug($slug);

        $this->userService->destroy($user);

        return redirect('/admin/users');
    }
}
