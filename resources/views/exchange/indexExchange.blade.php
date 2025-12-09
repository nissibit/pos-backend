@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'exchange';
    $subactive = 'exchange_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"> Painel do Cambio  </i></h2>
                @include('exchange.menuExchange')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-exchange")                    
            </div>
        </div>
    </div>
</div>
@endsection
