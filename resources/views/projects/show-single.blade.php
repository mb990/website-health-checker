@extends('layouts.app')
@section('title')
    View project
@endsection

@section('content')

    <div class="row justify-content-center">

        <h3 class="text-info">View project</h3><br>

    </div>

    @if($project->active == 0)

        <p class="text-danger">Project is currently inactive</p>

    @endif

    <br>

    <div class="row text-center">

        <div class="col-md-12">

            <p class="lead">Name: {{$project->name}}</p>

            <p class="lead">URLS:</p>

        </div>

        <div class="row">

            @if($project->urls)

                @foreach($project->urls as $url)

                    <div class="col-md-8">

                        <a href="/projects/{{$project->slug}}/{{$url->id}}/checks"><p class="lead">{{$url->url}}</p></a>
                        <hr>

                    </div>

                    @auth

                        @if(auth()->user()->id === $project->user_id)

                            <div class="col-md-2">

                                <a href="/projects/{{$project->slug}}/{{$url->id}}/edit">
                                    <button class="btn btn-success" type="submit">Edit</button>
                                </a>

                            </div>

                            <div class="col-md-2">

                                <form action="{{route('delete.projectUrl', $url->id)}}" method="POST"
                                      xmlns="http://www.w3.org/1999/html">
                                    @method('DELETE')
                                    @csrf

                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>

                            </div>

                        @endif

                    @endauth

                @endforeach

            @else

                <p>No urls for this project.</p>

            @endif

        </div>

    </div>

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ \Session::get('success') }}</li>
            </ul>
        </div>
    @endif

    <div class="row text-center">

        <div class="col-md-12">

            @auth

                @if(auth()->user()->id === $project->user_id && $project->active == 1)

                    <form action="{{route('store.projectUrl', $project->slug)}}" method="POST"
                          xmlns="http://www.w3.org/1999/html">
                        @csrf

                        <input name="url" type="text" placeholder="Add url here">

                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>

                    <br>

                    <form action="{{route('delete.project', $project->slug)}}" method="POST"
                          xmlns="http://www.w3.org/1999/html">
                        @method('DELETE')
                        @csrf

                        <button class="btn btn-danger" type="submit">Delete project</button>
                    </form>
                    <a href="/projects/{{$project->slug}}/edit">
                        <button class="btn btn-info">Edit project</button>
                    </a>
                    <br>
                    <a href="/projects/{{$project->slug}}/invite">
                        <button class="btn btn-success">Invite</button>
                    </a>
                    <br>
                @endif

                <a href="/projects/{{$project->slug}}/members">
                    <button class="btn btn-dark">Members</button>
                </a>
                <br>
                <a href="/projects/{{$project->slug}}/settings">
                    <button class="btn btn-primary">Project settings</button>
                </a><br><br>

                @if(auth()->user()->id !== $project->user_id)

                    <a href="/projects/{{$project->slug}}/members/{{auth()->user()->slug}}/remove">
                        <button class="btn btn-danger">Leave project</button>
                    </a>
                    <br>

                @endif

                <br>
                <h4>Share project</h4>

                <form action="{{route('share.project', $project->slug)}}">

                <input type="email" placeholder="Email" name="email">

                <button class="btn btn-primary" type="submit">Send</button>

                </form>

        </div>

    </div>

    @endauth

@endsection
