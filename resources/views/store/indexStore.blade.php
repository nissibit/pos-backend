@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'store';
    $subactive = 'store_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-building"> Painel do Armazem  </i></h2>
                @include('store.menuStore')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-store")                    
            </div>
        </div>
    </div>
</div>
@endsection
