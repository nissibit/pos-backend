<!DOCTYPE html>
<html>

<head>

    <title>{{ env('APP_NAME', 'APP') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3-theme-black.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ URL::asset('/img/favicon.png') }}" type="image/x-icon" />

</head>

<body class="w3-light-gray">
    <div class="w3-top">
        <div class="w3-margin">
            <div class="w3-bar w3-round-large w3-white w3-padding">
                <a href="#" class="w3-bar-item w3-button w3-round-large">
                    <img src="{{ asset('img/logo.png') }}" class="img-responsive img-rounded" style="max-width: 32px;" alt="{{ env('APP_NAME', 'APP') }}" />
                    {{ env('APP_NAME', 'APP') }}
                </a>
            </div>
        </div>
    </div>
    <br><br><br>
    <!-- Sidebar -->
    <div class="w3-container">
        <div class="w3-flex" style="align-items: center; justify-content: center;">
            <div class="">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>