@extends('layouts.app')
@section('title')
    View project
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">

                    <h3 class="text-info">View project</h3>

                </div>
                <br>

                <div class="panel-body">

                    <p class="lead">Name: {{$project->name}}</p>

                    <form action="{{action('ProjectController@delete', $project->slug)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                        @method('DELETE')
                        @csrf

                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
