@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'devolution';
    $subactive = 'devolution_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"> Painel de Devoluções  </i></h2>
                @include('devolution.menuDevolution')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-devolution")                    
            </div>
        </div>
    </div>
</div>
@endsection
