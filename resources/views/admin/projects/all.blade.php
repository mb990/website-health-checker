@extends('layouts.app')
@section('title')
    Projects
@endsection

@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Projects</h1>
    </div>

    @if(count($projects))

        @foreach ($projects as $project)

            <div class="row text-center">

                <div class="col-md-4">

{{--                    <a href="/projects/{{$project->slug}}">--}}
                        <p class="text-secondary"><strong>Name:</strong> {{ucfirst($project->name)}}</p>
{{--                    </a>--}}
{{--                    <a href="/admin/users/{{$project->creator->slug}}">--}}
                        <p class="text-secondary"><strong>Creator:</strong> {{$project->creator->first_name}} {{$project->creator->last_name}}</p>
{{--                    </a>--}}

                </div>

                <div class="col-md-4"><br>

                    @if($project->active)

                        <form action="{{route('deactivate.project', $project->slug)}}" method="POST">

                            @method('PUT')
                            @csrf
                            <input class="btn btn-danger" type="submit" value="Deactivate">

                        </form>

                    @else

                        <form action="{{route('activate.project', $project->slug)}}" method="POST">

                            @method('PUT')
                            @csrf
                            <input class="btn btn-success " type="submit" value="Activate">

                        </form>

                    @endif

                </div>

                <div class="col-md-4"><br>

                    <form action="{{route('destroy.project', $project->slug)}}" method="POST">

                        @method('DELETE')
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Delete">

                    </form>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <p class="p-3 mb-2 bg-warning text-dark">No projects at the moment.</p>

    @endif

    <div class="row justify-content-center">

        {{$projects->links()}}

    </div>

@endsection
