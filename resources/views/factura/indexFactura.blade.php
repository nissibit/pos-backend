@extends('layouts.xicompra')
@section('content')
<?php
$active = 'factura';
$subactive = 'factura_index';
?>
<x-panel-card>
    <x-slot:title>
        <h2 class="w3-text-theme">
            <i class="fas fa-dollar-sign"></i>
            @lang('messages.sale.panel')
        </h2>

    </x-slot:title>
    <x-slot:menu>
        @include('factura.menuFactura')
    </x-slot:menu>
    <div class="">
        <div id="alerts"></div>
        @include('menu.alert')
        <div>
            @yield("content-factura")
        </div>
    </div>
</x-panel-card>

@push('scripts')
<script>
    let _alerts = document.getElementById('alerts');
    let _content = document.getElementById('content-factura');
    let _modalAlerts = document.getElementById('modalAlert');

    document.addEventListener('DOMContentLoaded', function() {
        resetFacturaFormContent();
    });


    function resetFacturaFormContent() {
        _content.innerHTML = buildAlert('info', 'Bem vindo ao painel de facturas onde pode criar ou listar facturas.');

    }

    async function loadingFacturas(payed) {
        _content.innerHTML = _loading;
        let url = "{{ route('api.factura.list', ':payed') }}";
        url = url.replace(':payed', payed);

        try {
            let res = await fetch(url);
            let text = await res.text();
            _content.innerHTML = text;
            // resetFacturaFormContent();

        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar a lista das facturas: ${error.message}`);
        }
    }
    
    async function createFactura(payed) {
        _content.innerHTML = _loading;
        let url = "{{ route('api.factura.crete', ':payed') }}";
        url = url.replace(':payed', payed);

        try {
            let res = await fetch(url);
            let text = await res.text();
            _content.innerHTML = text;
            // resetFacturaFormContent();

        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar a lista das facturas: ${error.message}`);
        }
    }
</script>
@endpush
@endsection