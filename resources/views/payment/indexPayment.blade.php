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
        <div>
            @yield("content-payment")
        </div>
    </div>
</x-panel-card>
<x-modal>
    <x-slot:title>
        <div class="w3-flex" style="align-items: center; gap: 4px;">
            <div><i class="fas fa-save"></i></div>
            <div>
                <h3>Pagamento da factura</h3>
            </div>
        </div>
    </x-slot:title>
    <x-slot:footer>
        <div class="w3-section w3-grid" style="grid-template-columns: 1fr 1fr;">
            <div>
                <x-button onclick="toggleModal('modal', false); " class="w3-red w3-left">
                    <i class="fas fa-times"></i> fechar
                </x-button>
            </div>
            <div>
                <x-action-button type="button" onclick="printPDF()" id="btnPrintPDF" class="w3-block">
                    <i class="fas fa-print"></i> imprimir recibo
                </x-action-button>
            </div>
        </div>
    </x-slot:footer>
</x-modal>
@push('scripts')
<script>
    let _alerts = document.getElementById('alerts');
    let _content = document.getElementById('content-payment');
    let _modalAlerts = document.getElementById('modalAlert');

    document.addEventListener('DOMContentLoaded', () => {
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
            if (button.dataset.preview == 'true') {
                previewPayment(button.dataset.factura);

            } else {
                previewPayment(button.dataset.factura)
                printPDF();
            }
        }
        if (button.id == 'btnSavePayment') savePayment();
        if (button.id == 'btnPrintPDF') printPDF();
        if (button.id == "btnSaveCashier") saveCashier();

    });

    // End of Delegation Methods    
    function resetPaymentFormContent() {
        document.querySelector('#payment-form').innerHTML = buildAlert('info', 'Seleccione a factura para ver o formulário de pagamento específico.');

    }
    async function loadingInvoiceForPayment(payed) {
        _content.innerHTML = _loading;
        let url = "{{ route('factura.for.payment', ':payed') }}";
        url = url.replace(':payed', payed);

        try {
            let res = await fetch(url);
            let text = await res.text();
            _content.innerHTML = text;
            resetPaymentFormContent();

        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar a lista das facturas: ${error.message}`);
        }
    }





    function loadingCreatePayment(id) {
        try {
            let _innerContent = document.querySelector("#payment-form");
            _innerContent.innerHTML = _loading;
            let url = "{{ route('payment.create.direct',':id') }}";
            url = url.replace(':id', id);
            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _innerContent.innerHTML = res;
                    let methods = document.querySelectorAll(".payment_method");
                    if (methods.length > 0) {
                        methods[0].focus();
                    }
                })
                .catch((error) => {
                    _innerContent.innerHTML = buildAlert('info',
                        `Ocorreu um erro ao carregar formulário de pagamento: ${error.message}`);
                });
        } catch (error) {
            _innerContent.innerHTML = buildAlert('info',
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
        let _innerContent = document.querySelector('#modalContent');
        _innerContent.innerHTML = _loading

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
                    _innerContent.innerHTML = resp;
                }).catch(error => {
                    _con_innerContenttent.innerHTML = buildAlert('error', error.message)
                })
        } catch (error) {
            _innerContent.innerHTML = buildAlert('error', error.message)
        }

    }

    function previewPayment(id) {
        toggleModal('modal', true);
        let _innerContent = document.querySelector('#modalContent');
        try {
            _innerContent.innerHTML = _loading;
            let url = "{{ route('payment.preview',':id') }}";
            url = url.replace(':id', id);
            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _innerContent.innerHTML = res;
                })
                .catch((error) => {
                    _innerContent.innerHTML = buildAlert('error',
                        `Ocorreu um erro ao visualizar o pagamento: ${error.message}`);
                });
        } catch (error) {
            _innerContent.innerHTML = buildAlert('error',
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
    // Cashier
    function loadingCashiers() {
        let _content = document.getElementById('content-payment');
        try {
            _content.innerHTML = _loading;
            let url = "{{ route('cashier.index') }}";

            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _content.innerHTML = res;
                })
                .catch((error) => {
                    _content.innerHTML = buildAlert('info',
                        `Ocorreu um erro ao carregar a lista de caixas: ${error.message}`);
                });
        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar a lista de caixas: ${error.message}`);
        }
    }

    function loadingCashierCreate() {
        let _content = document.getElementById('content-payment');
        try {
            _content.innerHTML = _loading;
            let url = "{{ route('cashier.create') }}";

            fetch(url)
                .then((res) => res.text())
                .then((res) => {
                    _content.innerHTML = res;
                })
                .catch((error) => {
                    _content.innerHTML = buildAlert('info',
                        `Ocorreu um erro ao carregar formulário de abertura de caixa: ${error.message}`);
                });
        } catch (error) {
            _content.innerHTML = buildAlert('info',
                `Ocorreu um erro ao carregar formulário de aberura de caixa: ${error.message}`);
        }
    }

    function saveCashier() {
        let _form = document.querySelector('#form_cashier_create');
        let _innerAlert = document.querySelector("#alert-cashier-create");
        _innerAlert.innerHTML = _loading

        try {
            let url = "{{ route('cashier.store') }}";
            let formData = new FormData(_form);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                    headers: {
                        "X-CSRF-TOKEN": token
                    },
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(resp => {
                    _innerAlert.innerHTML = resp;
                    _form.reset();
                }).catch(error => {
                    _innerAlert.innerHTML = buildAlert('error', error.message)
                })
        } catch (error) {
            _innerAlert.innerHTML = buildAlert('error', error.message)
        }

    }
</script>
@endpush
@endsection