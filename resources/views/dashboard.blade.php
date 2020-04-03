@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')

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

            <a href="/settings/{{auth()->user()->slug}}"><button class="btn btn-primary">Global notification settings</button></a>

        </div>

    </div>

@endsection
