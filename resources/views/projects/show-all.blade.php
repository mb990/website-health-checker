@extends('layouts.app')
@section('title')
    Projects
@endsection

@section('content')

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

                    <div class="row">

                        <div class="col-md-8">

                            <p class="lead">Name:</p>

                            <a href="/projects/{{$project->slug}}">

                                <p class="lead">{{ucfirst($project->name)}}</p>

                            </a>

                        </div>

                        @auth

                            <div class="float-right col-md-4">

                                @if(auth()->user()->id === $project->user_id)

                                   <br><label class="btn btn-success">my</label>

                                @endif

                                @foreach($project->members as $member)

                                    @if(auth()->user()->id === $member->pivot->user_id)

                                            <br><label class="btn btn-primary">on</label>

                                    @endif

                                @endforeach

                            </div>

                        @endauth

                    </div>

                    <hr>

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
