@extends('layouts.app')

@if(Request::is('profile'))
    @section('title', 'My Profile')
@else
    @section('title', $user->first_name . "'s Profile")
@endif

@section('content')
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif
    <view-profile-page></view-profile-page>
@endsection