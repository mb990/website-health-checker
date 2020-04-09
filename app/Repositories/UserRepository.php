<?php


namespace App\Repositories;

use App\User;
use function foo\func;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all() {

        return $this->user->all();
    }

    public function allPaginated($perPage) {

        return $this->user->paginate($perPage);
    }

    public function findById($id) {
//dd($id);
        return $this->user->find($id);
    }

    public function findBySlug($slug) {

        return $this->user->where('slug', '=', $slug)->first();
    }

    public function activate(User $user) {

        $user->update(['active' => true]);
    }

    public function deactivate(User $user) {

        $user->update(['active' => false]);
    }

    public function destroy(User $user) {

        $user->forceDelete();
    }
}
