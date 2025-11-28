@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'transference';
    $subactive = 'transference_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"> Painel de Transferências  </i></h2>
                @include('transference.menuTransference')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-transference")                    
            </div>
        </div>
    </div>
</div>
@endsection
