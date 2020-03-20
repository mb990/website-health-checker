@extends('layouts.app')

@section('title')
    Homepage
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="offset-4 col-md-6">

            <h1>Hello</h1>
{{$url->url}}
        </div>

    </div>
@endsection
