@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $profile->description }}">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta name="og:url" content="{{ url(env('APP_URL')) }}/profile/{{ $profile->id }}">
    <meta name="og:title" content="{{ $profile->first_name . '\'s Profile' }}">
    <meta name="og:description" content="{{ $profile->description }}">
    <meta name="og:image" content="{{ url(env('APP_URL')) }}{{ $profile->profile_picture_route }}">
@endpush

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
