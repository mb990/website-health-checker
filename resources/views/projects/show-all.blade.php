@extends('layouts.app')
@section('title')
    Projects
@endsection

@section('content')
    {{--    {{dd($courses)}}--}}

    <div class="jumbotron">
        <h1 class="text-center">Projects</h1>
    </div>

    <div class="row justify-content-center">

        <h2 class="text-primary">Projects</h2>

    </div><br><br><br>

    <div class="row">

        @if(count($projects))

            @foreach($projects as $project)

                <div class="col-md-4">

                    <p class="lead">Name:</p>
                    <p class="lead">{{$project->name}}</p><hr>

                </div>

            @endforeach

        @else

            <p class="lead">No projects.</p>

        @endif

    </div>

    <div class="row justify-content-center">

        {{ $projects->links() }}

    </div>

@endsection
