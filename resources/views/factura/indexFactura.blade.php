@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'factura';
    $subactive = 'factura_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-dollar-sign"> Painel das Vendas  </i></h2>
                @include('factura.menuFactura')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-factura")                    
            </div>
        </div>
    </div>
</div>
@endsection
