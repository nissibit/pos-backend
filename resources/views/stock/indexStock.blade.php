@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'stock';
    $subactive = 'stock_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-boxes"> Painel do Stock  </i></h2>
                @include('stock.menuStock')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-stock")                    
            </div>
        </div>
    </div>
</div>
@endsection
