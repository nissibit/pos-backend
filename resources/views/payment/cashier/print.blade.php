@extends("payment.cashier.indexCashier")
@section("content-cashier")
<div class="card">
   <div class="card-body">
        <iframe src="{{  route('report.cashier', ['id' => $cashier->id]) }}" width="100%" height="700px">
        </iframe>
    </div>
</div>
@endsection
