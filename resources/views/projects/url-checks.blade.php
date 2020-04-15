@extends('layouts.app')

@section('title')
    Checks for this url
@endsection

@section('content')

    <h3 class="text-center">{{$url->url}}</h3>

    <div class="row">

        <div class="col-md-6">

            {!! $chart->container() !!}

            {!! $chart->script() !!}

        </div>

        <div class="col-md-6">

            {!! $chart2->container() !!}

            {!! $chart2->script() !!}

        </div>

    </div>

@endsection
