<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;
class CheckRole
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
//            abort(401, 'This action is unauthorized.');
            return redirect('/');
        }
        return $next($request);
    }
}
