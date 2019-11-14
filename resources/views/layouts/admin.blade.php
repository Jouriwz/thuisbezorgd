<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Thuisbezorgd') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css" >
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <nav class="navbar mt-4">
            <div class="float-right ml-1">
                <a href="{{route('admin.profiles.index')}}" class="btn btn-secondary">Users</a>
                <a href="{{route('admin.restaurants.index')}}" class="btn btn-secondary">Restaurants</a>
                <a href="{{route('admin.consumables.index')}}" class="btn btn-secondary">Consumables</a>
            </div>
        </nav>
        @yield('content')
    </div>
</body>
</html>
