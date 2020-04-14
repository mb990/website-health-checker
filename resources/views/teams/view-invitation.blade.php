@extends('layouts.app')

@section('title')
    Project invitation
@endsection

@section('content')

    @auth

        <div class="row">

            <div class="col-md-12 text-center">

                <h1>Hello {{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</h1><br>;

                <h2>{{ucfirst($project->creator->first_name)}} {{ucfirst($project->creator->last_name)}} invited you to
                    join his project {{ucfirst($project->name)}}</h2><br>

                <form action="{{route('accept', $token)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-success">Accept</button>

                </form>

                <form action="{{route('reject', $token)}}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">Reject</button>

                </form>

            </div>

        </div>

    @endauth

    @guest

        <div class="row">

            <div class="col-md-12 text-center">

                <h1>Hello</h1><br>;

                <h2>{{ucfirst($project->creator->first_name)}} {{ucfirst($project->creator->last_name)}} invited you to
                    join his project {{ucfirst($project->name)}}</h2><br>

                <form action="{{route('accept.guest', $token)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-success">Accept</button>

                </form>

                <form action="{{route('reject', $token)}}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">Reject</button>

                </form>

            </div>

        </div>

    @endguest

@endsection
