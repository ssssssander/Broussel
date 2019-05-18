<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand|Open+Sans" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>{{ config('app.name', 'Broussel') }}</title>
</head>
<body>
    <div id="app">
        <app :is-auth="{{ $isAuth }}"></app>
    </div>
</body>
</html>
