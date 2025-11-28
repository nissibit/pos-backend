@extends('admin.index')
@section('content-admin')
<?php
    $active = 'product';
    $subactive = 'factura_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-trash"> Painel da Facturas removidas  </i></h2>
                @include('admin.factura.menuFactura')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-factura")                    
            </div>
        </div>
    </div>
</div>
@endsection
