@extends('layouts.app')
@section('title')
    View project
@endsection

@section('content')

    <div class="row justify-content-center">

        <h3 class="text-info">View project</h3>

    </div>

    <br>

    <div class="row text-center">

        <div class="col-md-12">

            <p class="lead">Name: {{$project->name}}</p>

            <p class="lead">URLS:</p>

        </div>

        <div class="row">

            @if($project->urls)

                @foreach($project->urls as $url)

                    <div class="offset-4 col-md-4">

                        <p class="lead">{{$url->url}}</p><hr>

                    </div>

                    <div class="offset-1 col-md-1">

                        <a href="/projects/{{$project->slug}}/{{$url->id}}/edit"><button class="btn btn-success" type="submit">Edit</button></a>

                    </div>

                    <div class="col-md-1">

                        <form action="{{action('ProjectUrlController@delete', $url->id)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                            @method('DELETE')
                            @csrf

                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>

                    </div>

                @endforeach

            @else

                <p>No urls for this project.</p>

            @endif

        </div>

    </div>

    <div class="row text-center">

        <div class="col-md-12">

            <form action="{{action('ProjectUrlController@store', $project->slug)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                @csrf

                <input name="url" type="text" placeholder="Add url here">

                <button class="btn btn-primary" type="submit">Add</button>
            </form>

            <br>

            <form action="{{action('ProjectController@delete', $project->slug)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                @method('DELETE')
                @csrf

                <button class="btn btn-danger" type="submit">Delete project</button>
            </form>

        </div>

    </div>

@endsection
