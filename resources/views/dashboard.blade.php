@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')

    <h2>My created projects</h2>

   @if(count($projects))

       @foreach($projects as $project)

           <a href="/projects/{{$project->slug}}"><p class="lead">{{$project->name}}</p></a>

       @endforeach

    @else

       You dont have projects.

    @endif

@endsection
