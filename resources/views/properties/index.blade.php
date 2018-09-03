@extends('layouts.app')

@push('meta')
    <meta name="description" content="Find the home you've been looking for. Search Rentt for your next home to rent.">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}/properties">
    <meta property="og:title" content="Search Rentt">
    <meta property="og:description" content="Find the home you've been looking for. Search Rentt for your next home to rent.">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/rentt-search.png">
    <meta property="og:type" content="product.group">
@endpush

@section('title', 'Properties')

@section('content')
<properties-page></properties-page>
@endsection
