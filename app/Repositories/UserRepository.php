<?php


namespace App\Repositories;

use App\User;
use Spatie\Permission\Traits\HasRoles;

class UserRepository
{
    use HasRoles;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all() {

        return $this->user->all();
    }

    public function admins() {

        return $this->user->role('admin')->get();
    }

    public function allPaginated($perPage) {

        return $this->user->paginate($perPage);
    }

    public function activeUsers() {

        return $this->user->where('active', '=', 1)
            ->get();
    }

    public function inactiveUsers() {

        return $this->user->where('active', '=', 0)
            ->get();
    }

    public function findById($id) {

        return $this->user->find($id);
    }

    public function findBySlug($slug) {

        return $this->user->where('slug', '=', $slug)->first();
    }

    public function findByEmail($email) {

        return $this->user->where('email', '=', $email)->first();
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

    public function assignRole(User $user, $role) {

        $user->assignRole($role);
    }

    public function storeAdmin ($attributes, $password) {

        $admin = $this->user->create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => $password
        ]);

        return $admin;
    }
}
