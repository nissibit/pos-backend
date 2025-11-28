<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Edson Pessane')  }} &circledR;</title>
        <link rel="icon" href="{{ URL::asset('/img/favicon.png') }}" type="image/x-icon"/>


        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/mainTemplate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">

        <!--Scripts--> 

         <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/dinheiro.js') }}"></script>
        <script src="{{ asset('js/jquery.ui.datepicker-pt.js') }}"></script>
        <script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
        <style>
            .main{
                background-image: url({{ asset("img/logo.png")}});
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            height: 75%;

            }
        </style>
    </head>
    <body class="bg-white">
        <div class="wrapper">
            <!-- Side Bar -->
            @include('layouts.sidebar')
            <!-- End Side Bar -->
            <!-- Page Content  -->
            <div id="content">
                @include('layouts.navcontent')
                <div class="main ">
                    @yield('content')
                </div>  
            </div>
        </div>
      <!-- Scripts -->
        
        <!-- <script src="{{ asset('js/bootstrap-confirmation.min.js') }}"></script> -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        @yield('scripts')
        <script type="text/javascript">
$(document).click(function () {
    $(".dinheiro").maskMoney({thousands: ',', decimal: '.', allowZero: true});

});
        </script>
    </body>
</html>
