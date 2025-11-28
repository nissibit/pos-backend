@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'price';
    $subactive = 'price_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-handshake"> Painel de Preços  </i></h2>
                @include('price.menuprice')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-price")                    
            </div>
        </div>
    </div>
</div>
@endsection
