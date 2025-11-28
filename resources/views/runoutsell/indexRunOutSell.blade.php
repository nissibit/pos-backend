@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'factura';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cubes"> Painel da Produtos vendidos sem Stock  </i></h2>
                @include('runoutsell.menuRunOutSell')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-runoutsell")                    
            </div>
        </div>
    </div>
</div>
@endsection
