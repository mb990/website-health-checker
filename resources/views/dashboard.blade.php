@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    @if($errors->any())
        <h4>{{$errors->first()}}</h4>
    @endif
    <div class="row text-center">

        <div class="col-md-8">

            <h2>My created projects</h2>

            @if(count($projects))

                @foreach($projects as $project)

                    <a href="/projects/{{$project->slug}}"><p class="lead">{{$project->name}}</p></a>

                @endforeach

            @else

                You dont have projects.

            @endif

        </div>

        <div class="col-md-4">

            <a href="/projects/create/new"><button class="btn btn-primary">New project</button></a>

            <a href="/settings/{{auth()->user()->slug}}"><button class="btn btn-primary">Global notification settings</button></a>

        </div>

    </div><br><hr>

    <div class="row text-center">

        <div class="col-md-8">

            <h2>Projects i joined</h2>

            @if(count($joinedProjects))

                @foreach($joinedProjects as $joinedProject)

                    <a href="/projects/{{$joinedProject->slug}}"><p class="lead">{{$joinedProject->name}}</p></a>

                @endforeach

            @else

                You didn't join any project.

            @endif

        </div>

@endsection
