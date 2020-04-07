@extends('layouts.app')

@section('title')
    Invite member
@endsection

@section('content')
    <div class="row text-center">

        <div class="col-md-12">

            <h1>Invite member to your team</h1>
{{--            @dd($users)--}}
            <form action="{{route('invite', $project->slug)}}"></form>

            <select id="user" name="user">

                @foreach($users as $user)
{{--                    @dd($user)--}}
                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>

                @endforeach

            </select>

        </div>

    </div>
@endsection
