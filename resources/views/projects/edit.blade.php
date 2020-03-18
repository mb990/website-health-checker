@extends('layouts.app')
@section('title')
    Edit project
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">

                    <h3 class="text-info">Edit project</h3>

                </div><br>

                <div class="panel-body">

                    <form action="{{action('ProjectController@update', $project->slug)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                        @method('PUT')
                        @csrf
                        <label for="project_name">Name</label>
                        <input class="form-control" name="name" type="text" id="project_name" placeholder="Project name" value="{{$project->name}}"><br>

                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
