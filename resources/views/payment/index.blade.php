@extends("payment.indexPayment")
@section("content-payment")
<div class="w3-grid-padding" style="grid-template-columns: 20% auto;">
    <div id="invoice_list"></div>
    <div id="payment_form">
        <x-simple-card message="Seleccione a factura para ver o formulário de pagamento específico." />
    </div>
</div>
@endsection