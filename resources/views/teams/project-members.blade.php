@extends('layouts.app')

@section('title')
    Project members
@endsection

@section('content')

    <h1 class="text-center">Project members</h1><br>

    @if(count($members))

        @foreach($members as $member)

            <div class="row text-center">

                <div class="col-md-4">

                    {{ucfirst($member->first_name)}} {{ucfirst($member->last_name)}}

                </div>

                @if($member->id != $project->creator->id)

                    <div class="col-md-4">

                        <form action="{{route('remove.member', [$project->slug, $member->slug])}}">

                            <button class="btn btn-danger">Remove</button>

                        </form>

                    </div>

                @endif

            </div><hr>

        @endforeach

    @endif
@endsection
