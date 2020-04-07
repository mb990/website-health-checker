@extends('layouts.app')

@section('title')
    Invite member
@endsection

@section('content')
    <div class="row text-center">

        <div class="col-md-12">

            <h1>Invite member to your team</h1>
{{--            @dd($users)--}}
            <form action="{{route('process', $project->slug)}}" method="POST">
                @csrf
                <select id="user" name="user">

                    @foreach($users as $user)
    {{--                    @dd($user)--}}
                        <option class="form-control" name="user" value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>

                    @endforeach

                </select><br><br>

                <button class="btn btn-success" type="submit" value="Submit">Submit</button>

            </form>

        </div>

    </div>
@endsection
