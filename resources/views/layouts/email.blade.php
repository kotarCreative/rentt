
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div style="margin: 0px auto; max-width: 600px;">
            <div>
                @yield('content')
                <h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 20px;">Thanks,</h4>
                <h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 0px;">The Rentt Team</h4>
            </div>
        </div>
    </body>
</html>
