@extends('layouts.app')
@section('title')
    Notification settings
@endsection

@section('content')

    @auth

        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">

                        <h3 class="text-info">Edit your notification settings</h3>

                        <h4>Project: {{$project->name}}</h4>

                    </div>
                    <hr>

                    <div class="col-md-12">

                        <form action="{{route('update.singleProject.notificationSettings', $project->slug)}}"
                              method="POST" xmlns="http://www.w3.org/1999/html">
                            @method('PUT')
                            @csrf
                            @foreach($settings as $setting)

                                <label for="active-{{$setting->id}}">{{$setting->type->name}}</label>&nbsp &nbsp &nbsp
                                &nbsp
                                <input class="form-check-input" @if ($setting->active == 1) checked
                                       @endif name="active-{{$setting->id}}" type="checkbox" id="active"><br>
                            @endforeach
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @endauth

@endsection
