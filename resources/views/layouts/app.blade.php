<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="SquadStats is a global repository for Squad player, match, and server statistics, pulled straight from the servers you play on.">

    <title>@yield('title') | SQUAD Stats</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    <header>
        @include('layouts.header')
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>