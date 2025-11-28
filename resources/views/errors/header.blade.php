<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- CSFR token for ajax call -->
        <meta name="_token" content="{{ csrf_token() }}"/>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Nissi Bit') }}</title>

        <!-- Bootstrap -->  
        <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css') }} " rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css') }} " rel="stylesheet">
        <!-- NProgress -->
        <link href="{{asset('vendors/nprogress/nprogress.css') }} " rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{asset('build/css/custom.min.css') }} " rel="stylesheet">
    </head>

    <body class="nav-md">
        @yield('content-error')

        <!-- jQuery         -->
        <script src="{{asset('vendors/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bo                otstrap -->
        <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{asset('vendors/fastclick/lib/fastclick.js') }}"></script>
        <!-- NProgress -->
        <script src="{{asset('vendors/nprogress/nprogress.js') }}"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{asset('build/js/custom.min.js') }}"></script>
    </body>
</html>