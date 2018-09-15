@extends('layouts.app')

@push('meta')
    <meta name="description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}/tenants">
    <meta property="og:title" content="How Rentt helps tenants">
    <meta property="og:description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/tenant-profile.png">
    <meta property="og:type" content="website">
@endpush

@section('title', 'How Rentt helps tenants')

@section('content')
<div id="content-page">
    <div class="row">
        <div class="content">
            <div class="xs-1-1">
                <h1 class="sub-header">Create a reusable rental application</h1>
            </div>
            <div class="xs-1-1">
                <p>Why fill out multiple applications when applying to rent? We let you create a tenant profile that includes all the information that landlords look for:</p>
                <ul>
                  <li>profile picture</li>
                  <li>brief personal description</li>
                  <li>spoken languages</li>
                  <li>linked accounts (LinkedIn and Airbnb)</li>
                  <li>rental history</li>
                  <li>references</li>
                  <li>pets</li>
                  <li>smoking / non-smoking</li>
                </ul>
                <p>And you’re not limited to using this profile on Rentt. Applying to rent on other websites? No problem! Just copy and paste the URL for your profile to share it with landlords on other rental sites.</p>
                <p>Welcome to the community!</p>
                @if(Auth::guest())
                <register-btn type="tenant"></register-btn>
                @endif
            </div>
        </div>
    </div>
    <div class="row secondary">
        <div class="content">
            <div class="xs-1-1">
                <h2 class="sub-header">What your profile might look like. <a href="/landlords" class="btn in-header">Check out a landlord's profile</a></h2>
            </div>
            <div class="xs-1-1">
              <img src="imgs/tenant-profile.png" width="100%">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
