@extends('layouts.app')

@section('title')
    Project invitation
@endsection

@section('content')

    <h1>Hello {{$projectInvitationData['recipientName']}}</h1><br>';

    <h3>'{{$projectInvitationData['senderName']}} invited you to join his project {{$projectInvitationData['project']}} <br>';

        <a href="{{route('accept.invitation', $token)}}">Click here</a> to accept.

@endsection
