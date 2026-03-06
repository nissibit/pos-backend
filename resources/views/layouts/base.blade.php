<!DOCTYPE html>
<html>

<head>

    <title>{{ env('APP_NAME', 'APP') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3-theme-black.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ URL::asset('/img/favicon.png') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>

<body class="w3-light-gray">
    <div class="w3-top">
        <div class="w3-margin">
            <div class="w3-bar w3-round-large w3-white w3-padding">
                <a href="#" class="w3-bar-item w3-button w3-round-large">
                    <img src="{{ asset('img/logo.png') }}" class="img-responsive img-rounded" style="max-width: 32px;" alt="{{ env('APP_NAME', 'APP') }}" />
                    {{ env('APP_NAME', 'APP') }}
                </a>
                <a href="#" class="w3-bar-item w3-button w3-round-large w3-right">
                    <i class="fas fa-user-circle w3-circle"></i> {{ auth()->user()->name ?? 'N/A' }}
                </a>
            </div>
        </div>
    </div>
    <br><br><br>
    <!-- Sidebar -->
    <div class="w3-container">
        <div class="w3-grid-padding" style="grid-template-columns:250px auto">
            @include('layouts.sidebar')
            <!-- FIM Sidebar -->
            <div class="w3-white w3-round-large w3-margin-top w3-padding w3-topbar w3-border-theme">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{asset('js/w3.js.js') }}" defer></script>
    @include('layouts.footer-script')
</body>

</html>