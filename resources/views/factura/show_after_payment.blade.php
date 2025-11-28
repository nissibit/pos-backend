@extends("factura.indexFactura")
@section("content-factura")
<div class="card">
    <div class="card-body">
        <div class="row">
             <div class="col-sm-2">
                @include('payment.info')
            </div>
            <div class="col">
                <iframe src="{{  route('report.factura', ['id' => $payment->id]) }}" width="100%" height="700px">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
