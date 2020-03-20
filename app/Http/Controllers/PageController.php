<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class PageController extends Controller
{
    protected $projectService;
    protected $userService;

    public function __construct(ProjectService $projectService, User $userService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
    }

    public function index() {

        return view('welcome');
    }

    public function dashboard() {

        $projects = auth()->user()->createdProjects;
//        dd($projects);
        return view('dashboard')->with('projects', $projects);
    }
}
