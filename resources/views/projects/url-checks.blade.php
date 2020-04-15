@extends('layouts.app')

@section('title')
    Checks for this url
@endsection

@section('content')

    <h3 class="text-center">{{$url->url}}</h3>

    <div class="row">

        <div class="col-md-12">

            {!! $chart->container() !!}

            {!! $chart->script() !!}

        </div>

    </div>

@endsection
