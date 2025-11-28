@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'stocktaking';
    $subactive = 'stocktaking_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-boxes"> Painel do StockTaking  </i></h2>
                @include('stocktaking.menuStockTaking')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-stocktaking")                    
            </div>
        </div>
    </div>
</div>
@endsection
