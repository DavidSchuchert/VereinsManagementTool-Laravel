<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/confirm-delete.js'])
</head>

<body>
    @include('layouts.navigation')


    <!-- Page Heading -->

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <x-toast />
    </div>
    @yield('scripts')
</body>

</html>
