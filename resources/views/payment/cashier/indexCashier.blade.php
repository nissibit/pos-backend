@extends('payment.indexPayment')
@section('content-payment')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file-archive"> @lang('messages.cashier.panel')</i></h2>
                @include('payment.cashier.menuCashier')
            </div>
            <div class="card-body">
                 @yield("content-cashier")                    
            </div>
        </div>
    </div>
</div>
@endsection
