@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $property->description }}">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta name="og:url" content="{{ url(env('APP_URL')) }}/properties/{{ $property->slug }}">
    <meta name="og:title" content="{{ $property->title }}">
    <meta name="og:description" content="{{ $property->description }}">
    <meta name="og:image" content="{{ url(env('APP_URL')) }}{{ $property->image_routes[0] }}">
@endpush

@section('title', $property->title)

@section('content')
@if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
@endif
<single-property-page :property="{{ json_encode($property) }}"></single-property-page>
@endsection
