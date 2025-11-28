@extends('admin.index')
@section('content-admin')
<?php
    $active = 'product';
    $subactive = 'currency_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-coins"> Painel da Moeda  </i></h2>
                @include('admin.currency.menuCurrency')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-currency")                    
            </div>
        </div>
    </div>
</div>
@endsection
