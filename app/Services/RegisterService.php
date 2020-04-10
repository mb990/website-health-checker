<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function hashPassword($password) {

        $hash = Hash::make($password);

        return $hash;
    }

    public function validateRegistration($request) {

        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'string|required|min:8|confirmed',
        ]);
    }
}
