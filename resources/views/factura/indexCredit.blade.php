@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'credit';
    $subactive = 'credit_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-dollar-sign"> Painel de Creditos  </i></h2>
                @include('credit.menuCredit')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-credit")                    
            </div>
        </div>
    </div>
</div>
@endsection
