<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitedUserRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\InviteService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $projectService;
    protected $inviteService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectService $projectService, InviteService $inviteService)
    {
        $this->middleware('guest');

        $this->projectService = $projectService;
        $this->inviteService = $inviteService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showInvitedRegistrationForm($token) {

        $invite = $this->inviteService->findByToken($token);

        $email = $invite->email;

        return view('auth.register-invited')
            ->with('email', $email)
            ->with('token', $token);
    }

    protected function createInvited(InvitedUserRequest $request, $token) {

        $invite = $this->inviteService->findByToken($token);

        $email = $invite->email;

        $project = $this->projectService->readById($invite->project_id);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $email,
            'password' => Hash::make($request->input('password')),
        ]);

        $this->projectService->addUserToProject($project, $user);

        $this->inviteService->delete($token);

        return redirect('/dashboard');
    }
}
