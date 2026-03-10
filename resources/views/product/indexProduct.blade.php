@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'products';
?>

<x-panel-card>
    <x-slot:title>
        <h2 class="w3-text-theme">
            <i class="fas fa-cube"></i>
            @lang('messages.product.panel')
        </h2>

    </x-slot:title>
    <x-slot:menu>
        @include('product.menuProduct')
    </x-slot:menu>
    <div class="">
        <div id="alerts"></div>
        @include('menu.alert')
        <div id="content-products">
            @yield("content-products")
        </div>
    </div>
</x-panel-card>
@endsection
