@extends('layouts.app')

@section('title')
    Edit url
@endsection

@section('content')
    <h2>Edit url here.</h2>

    <div class="offset-4 col-md-4">

        <form action="{{action('ProjectUrlController@update', $url->id)}}" method="POST" xmlns="http://www.w3.org/1999/html">
            @method('PUT')
            @csrf

            <button class="btn btn-success" type="submit">Submit</button>
        </form>

    </div>
@endsection
