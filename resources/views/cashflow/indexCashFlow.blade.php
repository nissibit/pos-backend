@extends('payment.indexPayment')
@section('content-payment')
<?php
    $active = 'cashflow';
    $subactive = 'cashflow_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"> Painel de Entradas e Saidas  </i></h2>
                @include('cashflow.menuCashFlow')
            </div>
            <div class="card-body">
                @yield("content-cashflow")                    
            </div>
        </div>
    </div>
</div>
@endsection
