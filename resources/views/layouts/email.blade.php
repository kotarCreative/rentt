
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div style="margin: 0px auto; max-width: 600px;">
            <div style="padding: 15px 0px;">
                <a href="{{ route('home') }}">
                    <img class="rentt-logo" src="{{ url('/imgs/wordmark.png') }}" width="100px">
                </a>
            </div>
            <div>
                @yield('content')
            </div>
        </div>
    </body>
</html>
