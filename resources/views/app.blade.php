<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{asset('/css/app.css')}}" rel="stylesheet">

    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
    <audio controls>
        <source src="{{asset('01.mp3')}}" type="audio/ogg">
        Your browser does not support the audio element.
    </audio>
</body>
</html>
