<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if (Auth::guest())
            <active-user :user="null" role="guest"></active-user>
        @else
            <active-user :user="{{ Auth::user() }}" role="{{ Auth::user()->hasRole('tenant') ? 'tenant' : 'landlord' }}"></active-user>
        @endif
        <main-header show-filters="{{ Request::is('properties') ? 'true' : 'false' }}"></main-header>
        <div id="main-content">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    @include('layouts.scripts')
</body>
</html>
