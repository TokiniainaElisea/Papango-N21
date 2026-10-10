<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Papango N21') }}</title>


    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <script src="{{ asset('js/chart.js') }}"> </script>
    @include('navigation.header')
    <div class="container-fluid d-flex">
        @include('navigation.sidebar')
        <div class="flex-grow-1 my-2">
            @if (session('success'))
            <div class="card-body bg-success text-light p-2 mx-4">
                {{ session('success') }}
            </div>
        @endif
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
