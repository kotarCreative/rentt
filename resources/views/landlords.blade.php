@extends('layouts.app')

@push('meta')
    <meta name="description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}/landlords">
    <meta property="og:title" content="How Rentt helps landlords">
    <meta property="og:description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/landlord-profile.png">
    <meta property="og:type" content="website">
@endpush

@section('title', 'How Rentt helps landlords')

@section('content')
<div id="content-page">
    <div class="row">
        <div class="content">
            <div class="xs-1-1">
                <h1 class="sub-header">Save your listings for later</h1>
            </div>
            <div class="xs-1-1">
                <p>Easily manage multiple listings on your landlord profile. Once the property is rented, you can set the status to “Occupied”, which will remove it from search but keep it saved on your profile. Need to repost the listing? No problem, just set the status back to “Active” and it will show in search again.</p>
                <p>Your profile also lets you stand out as the awesome landlord that you are. Show your photo, a brief description, spoken languages, and linked accounts (LinkedIn and Airbnb). You can also ask your previous tenants to leave a positive review on your profile so that it’s extra enticing for future tenants.</p>
                <p>Welcome to the community!</p>
                @if(Auth::guest())
                <register-btn type="landlord"></register-btn>
                @endif
            </div>
        </div>
    </div>
    <div class="row secondary">
        <div class="content">
            <div class="xs-1-1">
                <h2 class="sub-header">What your profile might look like. <a href="/tenants" class="btn in-header">Check out a tenant's profile</a></h2>
            </div>
            <div class="xs-1-1">
              <img src="imgs/landlord-profile.png" width="100%">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
