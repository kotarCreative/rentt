<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if (env('USE_GOOGLE_TAG_MANAGER', false))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K8LGB8J');</script>
    <!-- End Google Tag Manager -->
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @if (env('USE_GOOGLE_TAG_MANAGER', false))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8LGB8J"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    <div id="app">
        @if (Auth::guest())
            <active-user :user="null" role="guest"></active-user>
        @else
            <active-user :user="{{ Auth::user() }}" role="{{ Auth::user()->hasRole('tenant') ? 'tenant' : 'landlord' }}"></active-user>
        @endif
        <div id="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @include('layouts.scripts')
</body>
</html>
