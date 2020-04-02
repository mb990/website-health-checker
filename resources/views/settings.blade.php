@extends('layouts.app')

@section('title')
    Settings
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="offset-4 col-md-6">

            <h1>Update your settings</h1>

            @foreach($settings as $setting)

                {{$setting->id}} <br>

            @endforeach

        </div>

    </div>
@endsection
