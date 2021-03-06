@extends('layouts.app')

@section('title')
    Edit url
@endsection

@section('content')

    @auth

        @if(auth()->user()->id != $url->project->user_id)

            <h1>You dont have permissions.</h1>

        @else

            <div class="row text-center">

                <div class="col-md-12">

                    <h2>Edit url</h2>

                </div>

            </div>

            <div class="row text-center">
                <div class="offset-4 col-md-4">
                    <form action="{{route('update.projectUrl', $url->id)}}" method="POST"
                          xmlns="http://www.w3.org/1999/html">
                        @method('PUT')
                        @csrf

                        <label class="form-control" for="check_frequency_id">Change check frequency</label>
                        <select class="form-control" name="check_frequency_id" id="check_frequency_id">
                            @foreach($frequencies as $frequency)
                                <option @if ($frequency->id === $url->check_frequency_id) selected
                                        @endif value={{$frequency->id}}>{{$frequency->name}}</option>
                            @endforeach
                        </select><br>

                        <button class="btn btn-success" type="submit">Change</button>
                    </form>

                </div>

            </div>

        @endif

    @endauth

@endsection
