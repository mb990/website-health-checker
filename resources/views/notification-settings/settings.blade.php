@extends('layouts.app')
@section('title')
    Notification settings
@endsection

@section('content')
{{--@dd($settings)--}}
    @auth

{{--        @if(auth()->user()->id != $setting->user_id)--}}

{{--            <h1>You dont have permissions.</h1>--}}

{{--        @else--}}

            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">

                            <h3 class="text-info">Edit notification settings for all projects</h3>

                        </div><br>

{{--                        @dd($user->notificationTypes->first())--}}
{{--                        @dd($globalSettings)--}}

                        <div class="col-md-12">

                            <form action="{{route('update.global.notificationSettings', $user->slug)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                                @method('PUT')
                                @csrf

                                @foreach($user->notificationTypes as $type)
{{--                                    @dd($user->notificationTypes)--}}
                                    <label for="active-{{$type->id}}">{{$user->notificationTypes[$type->pivot->notification_type_id -1]->name}}</label> &nbsp &nbsp &nbsp &nbsp
                                    <input class="form-check-input" @if ($type->pivot->active == 1) checked @endif name="active-{{$type->id}}" type="checkbox" id="active"><br>
                                @endforeach
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

{{--        @endif--}}

    @endauth

@endsection
