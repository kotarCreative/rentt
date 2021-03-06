@extends('layouts.app')

@push('meta')
    <meta name="description" content="Post free rental listings and search reviews on landlord and tenant profiles. Find your next home with us!">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}">
    <meta property="og:title" content="Find Good People">
    <meta property="og:description" content="Post free rental listings and search reviews on landlord and tenant profiles. Find your next home with us!">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/rentt-search.png">
    <meta property="og:type" content="website">
@endpush

@section('title', 'Find Good People')

@section('content')
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif
    <div id="content-page">
        <div class="row">
            <div class="content">
                <div id="hero-banner">
                    <div class="tagline">
                        <h1>Rentt:</h1><h2 class="description">Find good people.</h2>
                    </div>
                    <div id="search">
                        <property-search></property-search>
                    </div>
                </div>
            </div>
        </div>
        <div class="row secondary">
            <div class="content">
                <div class="xs-1-1">
                    <h2 class="sub-header">We help good landlords and tenants find each other.</h2>
                </div>
                <div class="sm-1-2 xs-1-1 sub-content-left">
                    <div class="tagline">
                        <h2>Tenants:</h2><h3 class="description">Read and write reviews about landlords</h3>
                    </div>
                    <p>Had a bad experience with a landlord? Wanna give kudos to a great landlord? Leave a review on their profile so that future tenants can be aware of what they may be getting themselves into. Read reviews left by past tenants to get a sense of what your prospective landlord is like.</p>
                    <p><a class="link secondary" href="/tenants">Learn more about tenant profiles.</a></p>
                    @if(Auth::guest())
                    <register-btn type="tenant"></register-btn>
                    @endif
                </div>
                <div class="sm-1-2 xs-1-1 sub-content-right">
                    <div class="tagline">
                        <h2>Landlords:</h2><h3 class="description">Screen potential tenants</h3>
                    </div>
                    <p>View profiles of tenants to see their rental history, reviews left by previous landlords and references. This allows you to determine which candidates you would like to book a viewing with and frees up your calendar from viewings with candidates that you know won't be a good fit.</p>
                    <p><a class="link secondary" href="/landlords">Learn more about landlord profiles.</a></p>
                    @if(Auth::guest())
                    <register-btn type="landlord"></register-btn>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content flex">
                <div class="xs-1-1">
                    <h2 class="sub-header">Here's some ways we think we can make your rental experience better:</h2>
                </div>
                <div class="sm-1-2 xs-1-1">
                    <div class="tagline">
                        <h2>Standardized Listing Info:</h2>
                    </div>
                    <p>Utilities, size, number of bedrooms, number of bathrooms, amenities, photos, and damage deposit...on every listing. We have landlords post everything up front in the same format to make navigation easier.</p>
                </div>
                <div class="sm-1-2 xs-1-1 mobile-centered">
                    <img src="/imgs/soup_cans.png" width="100%">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content flex mobile-reverse">
                <div class="sm-1-2 xs-1-1 mobile-centered">
                    <img src="/imgs/houses.png" width="100%">
                </div>
                <div class="sm-1-2 xs-1-1">
                    <div class="tagline">
                        <h2>Property Reviews:</h2>
                    </div>
                    <p>Reviews can be left for a property once you have gone for a viewing or are a tenant of that location. Read reviews left by others to get an idea of the condition of the property before going to look at it yourself.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content flex">
                <div class="sm-1-2 xs-1-1">
                    <div class="tagline">
                        <h2>Connected Accounts:</h2>
                    </div>
                    <p>Boost your profile by posting a link to your LinkedIn and Airbnb accounts. This allows landlords to see how great you are at work and as a guest at someone else’s home.</p>
                </div>
                <div class="sm-1-2 xs-1-1 mobile-centered">
                    <img src="/imgs/planets.png" width="80%">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('layouts.footer')
@endsection
