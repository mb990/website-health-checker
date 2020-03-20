@extends('layouts.app')

@section('title')
    Edit url
@endsection

@section('content')
    <div class="row text-center">

        <div class="col-md-12">

            <h2>Edit url</h2>

        </div>

    </div>

    <div class="row text-center">
{{--@dd($url->id)--}}
        <div class="offset-4 col-md-4">
            <form action="{{action('ProjectUrlController@update', $url->id)}}" method="POST" xmlns="http://www.w3.org/1999/html">
                @method('PUT')
                @csrf

                <label class="form-control" for="check_frequency_id">Change check frequency</label>
                <select class="form-control" name="check_frequency_id" id="check_frequency_id">
                    @foreach($frequencies as $frequency)
                        <option @if ($frequency->id === $url->check_frequency_id) selected @endif value={{$frequency->id}}>{{$frequency->name}}</option>
                    @endforeach
                </select><br>

                <button class="btn btn-success" type="submit">Change</button>
            </form>

        </div>

    </div>
@endsection
