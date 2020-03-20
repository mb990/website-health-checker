@extends('layouts.app')

@section('title')
    Checks for this url
@endsection

@section('content')

    @foreach($checks as $check)

        <p class="lead">Time: {{$check->created_at}}</p>
        <p class="lead">Response status: {{$check->response_code}}</p>
        <p class="lead">Response time: {{$check->response_time / 1000}} seconds</p><hr>

    @endforeach

@endsection
