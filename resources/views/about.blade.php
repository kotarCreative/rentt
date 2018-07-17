@extends('layouts.app')

@push('meta')
    <meta name="description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}/about">
    <meta property="og:title" content="What Rentt is About">
    <meta property="og:description" content="Rentt is a rental listing site that allows you to post and read reviews on tenant and landlord profiles.">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/main-logo.png">
    <meta property="og:type" content="website">
@endpush

@section('title', 'What Rentt is About')

@section('content')
<div id="content-page">
    <div class="row">
        <div class="content">
            <div class="xs-1-1">
                <h1 class="sub-header">Why we made Rentt</h1>
            </div>
            <div class="xs-1-1">
                <p>Rentt was created by Dave and Mike Buss (yea, we’re brothers) as a response to the frustrations we had experienced as both landlords and tenants.</p>
                <p>One question we asked was: why do landlords book showings and then check references AFTER the showing? This seems counterproductive - it would be more efficient to limit showings to people who already satisfy your requirements for references. Rentt’s tenant profile allows landlord to do exactly that.</p>
                <p>Another question we asked was: how do good tenants separate themselves from the rest? Having verifiable references, rental history, and connected accounts allows Rentt’s tenants to make the best impression possible.</p>
                <p>Beyond these things, our vision for Rentt is to create an all-in-one platform for the rental experience. At the moment we have focused on the pre-rental process, but we have plans to start introducing features that will allow Rentt to be a resource you can use during and after your lease. </p>
                <p>Welcome to the community!</p>
            </div>
        </div>
    </div>
    <div class="row secondary">
        <div class="content">
            <div class="xs-1-1">
                <h2 class="sub-header">Our Team</h2>
            </div>
            <div class="xs-1-1 team-photos">
                @foreach($team_members as $member)
                    <div class="team-photo-wrapper">
                        <a href="{{ $member->link }}" target="_blank">
                            <div class="team-photo-img-wrapper">
                                <img src="{{ $member->photo_link }}" width="200" />
                            </div>
                        </a>
                        <h5 class="team-photo-title">{{ $member->name }} - {{ $member->role }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
