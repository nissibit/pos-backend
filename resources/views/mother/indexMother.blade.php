@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'product';
    $subactive = 'product_principal';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cube"> Painel de Produto Principal </i></h2>
                @include('mother.menuMother')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-product")                    
            </div>
        </div>
    </div>
</div>
@endsection
