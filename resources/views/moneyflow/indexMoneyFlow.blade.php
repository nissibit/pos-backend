@extends('fund.indexFund')
@section('content-fund')
<?php
    $active = 'moneyflow';
    $subactive = 'moneyflow_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"> Painel de Saídas  </i></h2>
                @include('moneyflow.menuMoneyFlow')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-moneyflow")                    
            </div>
        </div>
    </div>
</div>
@endsection
