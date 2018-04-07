@extends('layouts.app')

@if(Request::is('profile'))
    @section('title', 'My Profile')
@else
    @section('title', $profile->first_name . "'s Profile")
@endif

@section('content')
    @if(session('success'))
        <div class="alert success" onclick="this.remove()">
            {{ session('success') }}
        </div>
    @endif
    <view-profile-page :profile="{{ json_encode($profile) }}"></view-profile-page>
@endsection
