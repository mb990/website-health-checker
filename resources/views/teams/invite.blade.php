@extends('layouts.app')

@section('title')
    Invite member
@endsection

@section('content')
    <div class="row text-center justify-content-center">

        <div class="col-md-6">

            <h1>Invite member to your team</h1>

            <form action="{{route('process', $project->slug)}}" method="POST">
                @csrf
                <select id="user" name="user">

                    <option disabled selected value> -- choose user --</option>

                    @foreach($users as $user)

                        <option class="form-control" name="user"
                                value="{{$user->id}}">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</option>

                    @endforeach

                </select><br><br>

                <h3>Invite guest</h3>

                <input class="form-control" type="text" name="guest" placeholder="Enter email"><br>

                <button class="btn btn-success" type="submit" value="Submit">Submit</button>

            </form>

        </div>

    </div>

    @if($errors->any())
        <h4>{{$errors->first()}}</h4>
    @endif

@endsection
