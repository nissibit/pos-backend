@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'creditnote';
    $subactive = 'creditnote_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-dollar-sign"> Painel de Nota de Crédito  </i></h2>
                @include('creditnote.menuCreditNote')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-creditnote")                    
            </div>
        </div>
    </div>
</div>
@endsection
