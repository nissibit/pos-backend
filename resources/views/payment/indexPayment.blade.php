@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'payment';
    $subactive = 'payment_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-dollar-sign"> @lang('messages.payment.panel')  </i></h2>
                @include('payment.menuPayment')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-payment")                    
            </div>
        </div>
    </div>
</div>
@endsection
