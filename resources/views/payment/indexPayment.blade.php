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
    <div class="">
        <div id="alerts"></div>
        @include('menu.alert')
        @yield("content-payment")
    </div>
</x-panel-card>
@push('scripts')
<script>
    let _alerts = document.getElementById('alerts');
    let _modalAlerts = document.getElementById('modalAlert');

    document.addEventListener('DOMContentLoaded', () => {
        // toggleModal('modal', false);    
        loadingInvoiceForPayment(false);
    });

    // Delegation Methods
    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('payment_method')) {
            sumAllMethods();
        }
    });
    document.addEventListener('click', (e) => {
        let button = e.target;
        if (button.classList.contains('btnCreatePayment')) {
            loadingCreatePayment(button.dataset.factura);
        }
          if (button.classList.contains('btnPreviewPayment')) {
            previewPayment(button.dataset.factura);
        }
        if ((button.id == 'btnSavePayment')) {
            savePayment();
        }
        if (button == 'btnPrintPDF') {

            printPDF();
        }
    });

    // End of Delegation Methods    
    function resetPaymentFormContent() {
        document.querySelector('#payment_form').innerHTML = buildAlert('info', 'Seleccione a factura para ver o formulário de pagamento específico.');

    }
    async function loadingInvoiceForPayment(payed) {
        let _content = document.getElementById('invoice_list');
        _content.innerHTML = _loading;
        resetPaymentFormContent();
        let url = "{{ route('factura.for.payment', ':payed') }}";
        url = url.replace(':payed', payed);

        try {
            let res = await fetch(url);
            let text = await res.text();
            _content.innerHTML = text;
        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar a lista das facturas: ${error.message}`);
        }
    }





    function loadingCreatePayment(id) {
        let _content = document.getElementById('payment_form');
        try {
            _content.innerHTML = _loading;
            let url = "{{ route('payment.create.direct',':id') }}";
            url = url.replace(':id', id);
            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _content.innerHTML = res;
                    let methods = document.querySelectorAll(".payment_method");
                    if (methods.length > 0) {
                        methods[0].focus();
                    }
                })
                .catch((error) => {
                    _content.innerHTML = buildAlert('info',
                        `Ocorreu um erro ao carregar formulário de pagamento: ${error.message}`);
                });
        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar formulário de pagamentos: ${error.message}`);
        }
    }

    function sumAllMethods() {
        let totalReceived = 0;

        document.querySelectorAll('.payment_method').forEach(input => {
            let value = parseFloat(input.value.replace(',', '.'));
            if (!isNaN(value)) {
                totalReceived += value;
            }
        });

        // Valor por pagar (vem formatado, então limpamos)
        let dueAmount = parseFloat(
            document.getElementById('payment_dueAmount')
            .value.replace(/\./g, '')
            .replace(',', '.')
        );

        // Actualizar recebido
        document.getElementById('payment_received').value = totalReceived;
        document.getElementById('payment_received_label').innerText =
            totalReceived.toLocaleString('pt-PT', {
                minimumFractionDigits: 2
            });

        // Calcular troco
        let change = totalReceived - dueAmount;
        document.getElementById('payment_changes').value = change;

        document.getElementById('payment_changes_label').innerText =
            (change > 0 ? change : 0)
            .toLocaleString('pt-PT', {
                minimumFractionDigits: 2
            });
    }

    function savePayment() {
        toggleModal('modal', true);
        let _form = document.querySelector('#form_create_payment');
        let _content = document.querySelector('#modalContent');
        _content.innerHTML = _loading

        try {
            let url = "{{ route('payment.save') }}";
            let formData = new FormData(_form);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log(_form, formData)
            fetch(url, {
                    headers: {
                        "X-CSRF-TOKEN": token
                    },
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(resp => {
                    _content.innerHTML = resp;
                }).catch(error => {
                    _content.innerHTML = buildAlert('error', error.message)
                })
        } catch (error) {
            _content.innerHTML = buildAlert('error', error.message)
        }

    }

    function previewPayment(id) {
        toggleModal('modal', true);
        let _content = document.querySelector('#modalContent');
        try {
            _content.innerHTML = _loading;
            let url = "{{ route('payment.preview',':id') }}";
            url = url.replace(':id', id);
            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _content.innerHTML = res;
                })
                .catch((error) => {
                    _content.innerHTML = buildAlert('error',
                        `Ocorreu um erro ao visualizar o pagamento: ${error.message}`);
                });
        } catch (error) {
            _content.innerHTML = buildAlert('error',
                `Ocorreu um erro ao visualizar pagamentos: ${error.message}`);
        }
    }

    function printPDF() {
        const iframe = document.getElementById('pdfFrame');
        console.log('imprimindo...')
        if (!iframe) return;

        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }
</script>
@endpush
@endsection