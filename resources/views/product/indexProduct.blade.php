@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'product';
    $subactive = 'product_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cube"> Painel de Produtos  </i></h2>
                @include('product.menuProduct')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-product")                    
            </div>
        </div>
    </div>
</div>
@endsection
