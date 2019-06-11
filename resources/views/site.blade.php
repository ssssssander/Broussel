<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#00f921">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#00f921">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand|Open+Sans" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/" defer></script>
    <script defer>
        (function(t,a,l,k,j,s){
            s=a.createElement('script');s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s)
            ;k=t.Promise;t.Talk={v:1,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e])});l
                        .push([f])},catch:function(){return k&&new k()},c:l}};})(window,document,[]);
    </script>

    <title>{{ config('app.name', 'Broussel') }}</title>
</head>
<body>
    <div id="site"></div>
</body>
</html>
