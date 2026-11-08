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
    <script src="{{ asset('js/chart.js') }}"></script>
    @include('navigation.header')
    <div class="container-fluid d-flex">
        @include('navigation.sidebar')
        <div class="flex-grow-1 my-2">
            {{-- Messages flash --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-4 fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                        aria-label="Fermer"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
