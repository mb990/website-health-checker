@extends('layouts.app')

@section('title')
    Project members
@endsection

@section('content')

    <h1 class="text-center">Project members</h1><br>

    @if(count($members))

        @foreach($members as $member)

            <div class="row text-center">

                <div class="col-md-4 @if($project->creator->id == $member->id) lead @endif">

                    {{ucfirst($member->first_name)}} {{ucfirst($member->last_name)}}

                </div>

                @if($project->creator->id == auth()->user()->id)

                    @if($member->id != $project->creator->id)

                        <div class="col-md-4">

                            <form action="{{route('remove.member', [$project->slug, $member->slug])}}">

                                <button class="btn btn-danger">Remove</button>

                            </form>

                        </div>

                    @endif

                @endif

            </div><hr>

        @endforeach

    @endif
@endsection
