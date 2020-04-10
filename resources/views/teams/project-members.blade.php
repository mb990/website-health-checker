@extends('layouts.app')

@section('title')
    Project members
@endsection

@section('content')
    <div class="row text-center">

        <div class="col-md-12">

            <h1>Project members</h1>

            <ul>

                @foreach($members as $member)

                    <li>{{ucfirst($member->first_name)}} {{ucfirst($member->last_name)}}

                        @if($member->id != $project->creator->id)

                            <form action="{{route('remove.member', [$project->slug, $member->slug])}}">

                                <button class="btn btn-danger">Remove</button>

                            </form>

                        @endif

                    </li>

                @endforeach

            </ul>

        </div>

    </div>
@endsection
