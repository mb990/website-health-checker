@extends('layouts.app')
@section('title')
    Users
@endsection

@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Users</h1>
    </div>

    @if(count($users))

        @foreach ($users as $user)

            <div class="row text-center">

                <div class="col-md-4">

{{--                    <a href="/admin/users/{{$user->slug}}">--}}

                        <p class="text-secondary"><strong>User:</strong> {{$user->first_name}} {{$user->last_name}}</p>

{{--                    </a>--}}

                </div>

                <div class="col-md-4">

                    @if($user->active)

                        <form action="{{route('deactivate.user', $user->slug)}}" method="POST">

                            @method('PUT')
                            @csrf
                            <input class="btn btn-danger" type="submit" value="Deactivate">

                        </form>

                    @else

                        <form action="{{route('activate.user', $user->slug)}}" method="POST">

                            @method('PUT')
                            @csrf
                            <input class="btn btn-success " type="submit" value="Activate">

                        </form>

                    @endif

                </div>

                <div class="col-md-4">

                    <form action="{{route('destroy.user', $user->slug)}}" method="POST">

                        @method('DELETE')
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Destroy">

                    </form>

                </div>

            </div>

            <hr>

        @endforeach

    @else

        <p class="p-3 mb-2 bg-warning text-dark">No users at the moment.</p>

    @endif

    <div class="row justify-content-center">

        {{$users->links()}}

    </div>

@endsection
