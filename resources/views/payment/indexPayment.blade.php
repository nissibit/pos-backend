@extends('layouts.xicompra')
@section('content')
<?php
$active = 'payment';
$subactive = 'payment_index';
?>
<x-panel-card>
    <x-slot:title>
        <h2 class="w3-text-theme">
            <i class="fas fa-dollar-sign"></i>
            @lang('messages.payment.panel')
        </h2>

    </x-slot:title>
    <x-slot:menu>
        @include('payment.menuPayment')
    </x-slot:menu>
    @include('menu.alert')
    @yield("content-payment")
</x-panel-card>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadingInvoiceForPayment(false);
    });

    function loadingInvoiceForPayment(payed) {
        let content = document.getElementById('invoice_list');
        content.innerHTML = _loading;
        let url = "{{ route('factura.for.payment', ':payed') }}";
        url = url.replace(':payed', payed)
        fetch(url)
            .then((res) => res.text())
            .then((res) => {
                content.innerHTML = res;
            })
            .catch((error) => {
                content.innerHTML = res;
                // content.innerHTML = `Error: ${JSON.parse(error)}`;
                console.log(error);
            });
    }
</script>

@endpush
@endsection