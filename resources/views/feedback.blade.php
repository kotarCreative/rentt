@extends('layouts.app')

@push('meta')
    <meta name="description" content="We want to know how you think Rentt is doing. Let us know what you think.">
    <meta name="keywords" content="Real Estate,Landlord,Tenant,Rental,Properties,Realtor,Home,Rent,Apartment,Suite">
    <meta property="og:url" content="{{ url(env('APP_URL')) }}/feedback">
    <meta property="og:title" content="Feedback for Rentt">
    <meta property="og:description" content="We want to know how you think Rentt is doing. Let us know what you think.">
    <meta property="og:image" content="{{ url(env('APP_URL')) }}/imgs/main-logo.png">
    <meta property="og:type" content="website">
@endpush

@section('title', 'Feedback')

@section('content')
<div id="content-page">
    <div class="row">
        <div class="content">
            <div class="xs-1-1">
                <h1 class="sub-header">Let us know what you think</h1>
            </div>
            <div class="xs-1-1">
                <p>Here at Rentt we believe things can always be better (which is why we built Rentt). The only way that we can improve is if you tell us how.</p>
                <p>Is there something missing? Something broken? Something that needs to change? Fill out the form below so that we can get to work on it.</p>
            </div>
        </div>
    </div>
    <div class="row secondary">
        <div class="content">
            <div class="xs-1-1">
                <h2 class="sub-header">Please fill out the form below</h2>
            </div>
            <div class="xs-1-1">
                <feedback-form></feedback-form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
