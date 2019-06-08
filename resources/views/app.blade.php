<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#00f921">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand|Open+Sans" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <title>{{ config('app.name', 'Broussel') }}</title>
</head>
<body>
    <div id="app"></div>
</body>
</html>
