@extends('layouts.xicompra')
@section('content')
<?php
$active = 'facturas';
$subactive = 'facturas_index';
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
        <div id="content-facturas">
            @yield("content-facturas")
        </div>
    </div>
</x-panel-card>
<x-modal>
    <x-slot:title>
        <div class="w3-flex" style="align-items: center; gap: 4px;">
            <div><i class="fas fa-save"></i></div>
            <div>
                <h3>Detalhes da factura</h3>
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
            </div>
        </div>
    </x-slot:footer>
</x-modal>
@push('scripts')
<script>
    let _alerts = document.getElementById('alerts');
    let _content = document.getElementById('content-facturas');
    let _modalAlerts = document.getElementById('modalAlert');

    document.addEventListener('DOMContentLoaded', function() {
        resetFacturaFormContent();
    });


    function resetFacturaFormContent() {
        _content.innerHTML = buildAlert('info', 'Bem vindo ao painel de facturas onde pode criar ou listar facturas.');

    }

    async function loadingFacturas(payed) {
        _alerts.innerHTML = '';
        let url = "{{ route('facturas.list', ['payed'=>':payed']) }}";
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

    async function createFactura() {
        _alerts.innerHTML = '';
        _content.innerHTML = _loading;
        let url = "{{ route('facturas.create') }}";

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


    async function displayFactura(id) {
        _alerts.innerHTML = '';
        let url = "{{ route('facturas.display', ':factura') }}";
        url = url.replace(':factura', id);
        try {
            let res = await fetch(url);
            let resp = await res.text();
            Swal.fire({
                title: "Dados da factura",
                html: resp,
                width: '50%',
                customClass: {
                    htmlContainer: 'meu-alinhamento-esquerdino'
                }
            })
            _alerts.innerHTML = ''
            // _content.innerHTML = resp;

        } catch (e) {
            console.log(e)
            _alerts.innerHTML = buildAlert('error', `Ocorreu um erro ao buscar dados da factura: ${e.message}`);
        }
    }



    async function copyFactura(factura) {
        console.log(`Factura recebida: ${factura}`);

        try {
            Swal.fire({
                title: `Tem certeza que pretende copiar a factura: ${factura}?`,
                showCancelButton: true,
                confirmButtonText: "Sim",
                showLoaderOnConfirm: true,
                preConfirm: async (result) => {
                    try {
                        let url = "{{ route('api.facturas.show', ':factura') }}";
                        url = url.replace(':factura', factura);
                        const response = await fetch(url);
                        if (!response.ok) {
                            return Swal.showValidationMessage(`Ocorreu um erro ao buscar dados da factura: ${factura}`);
                        }
                        return await response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    let items = result.value.data.items
                    // Envia os items para Alpine
                    window.dispatchEvent(new CustomEvent('factura-copiada', {
                        detail: items
                    }));

                    Swal.fire({
                        title: `Foram copiados: ${items.length} produto(s).`,
                        icon: 'success'
                    });
                }
            }).catch((error) => {
                Swal.fire({
                    title: `Falha na copia!`,
                    icon: 'error',
                    text: error.message
                });
            });

        } catch (e) {
            _alerts.innerHTML = buildAlert('error', `Ocorreu um erro ao buscar dados da factura: ${e.message}`);
        }
    }

    function facturacaoApp() {
        return {
            customer: Alpine.$persist({
                name: '',
                nuit: '',
                tel: '',
                address: ''
            }).as('c_v3'),
            itemsFactura: Alpine.$persist([]).as('f_v3'),

            busca: '',
            produtosFiltrados: [],
            carregando: false,

            // Chamada à API para Pesquisa
            async filtrarProdutos() {
                if (this.busca.length < 2) {
                    this.produtosFiltrados = [];
                    return;
                }

                this.carregando = true;
                try {
                    // NOTA: Substitua pelo seu URL real. 
                    // O parâmetro 'q' envia o termo de pesquisa para o servidor processar os 3000 items.
                    let url = "{{ route('api.products.fetch', ['q' => ':q']) }}";
                    url = url.replace(':q', this.busca);
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    const data = await response.json();

                    // Espera-se que a API retorne um array de objectos: [{id:1, name:'...', price:10.0}, ...]
                    this.produtosFiltrados = data;
                } catch (error) {
                    console.error("Erro ao procurar produtos:", error);
                    // Mock para teste caso a API falhe (remover em produção)
                    this.produtosFiltrados = [{}];
                } finally {
                    this.carregando = false;
                }
            },

            seleccionarProduto(p) {
                let existente = this.itemsFactura.find(i => i.id === p.id);
                existente ? existente.quantity++ : this.itemsFactura.push({
                    ...p,
                    quantity: 1
                });
                this.busca = '';
                this.produtosFiltrados = [];
            },

            removerItem(index) {
                this.itemsFactura.splice(index, 1);
            },

            cancelarTudo() {
                Swal.fire({
                    title: "Tem certeza que pretende cancelar?",
                    showDenyButton: true,
                    confirmButtonText: "Sim",
                    denyButtonText: 'Não'
                }).then((result) => {
                    this.clearAllForm();

                });
            },
            clearAllForm() {
                this.itemsFactura = [];
                this.customer = {
                    name: '',
                    nuit: '',
                    tel: '',
                    address: ''
                };
                localStorage.clear();
            },
            calcularSubtotal() {
                return this.itemsFactura.reduce((s, i) => s + (i.price * i.quantity), 0);
            },
            calcularTotal() {
                return this.calcularSubtotal();
            },

            async enviarParaAPI() {
                if (this.itemsFactura.length === 0) {
                    Swal.fire({
                        title: 'Informação!',
                        text: 'Adicione pelo menos um produto para dar continuidade',
                        icon: 'info',
                        // confirmButtonText: 'Ok'
                    });
                    return;
                };
                if (this.customer.name.length === 0) {
                    Swal.fire({
                        title: 'Alerta!',
                        text: 'Preencha o name do customer',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }

                const payload = {
                    customer: this.customer,
                    items: this.itemsFactura,
                    valores: {
                        subtotal: this.calcularSubtotal(),
                        total: this.calcularTotal()
                    }
                };

                try {
                    _alerts.innerHTML = _loading;
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let url = "{{route('api.facturas.store')}}"
                    let res = await fetch(url, {
                        headers: {
                            "X-CSRF-TOKEN": token,
                            'Content-Type': 'application/json'
                        },
                        method: 'POST',
                        body: JSON.stringify(payload)
                    });
                    const resp = await res.json()
                    if (!resp.ok) {
                        Swal.fire({
                            title: 'Falha!',
                            text: resp.message,
                            icon: 'error',
                        });
                    }
                    _alerts.innerHTML = ''; // Limpa o loading

                    Swal.fire({
                        title: 'Sucesso!',
                        text: resp.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        this.clearAllForm();
                    });
                } catch (e) {
                    console.log(e)
                    _alerts.innerHTML = buildAlert('error', `Ocorreu um erro ao guardar factura: ${e.message}`);
                }
            },
            init() {

                window.addEventListener('factura-copiada', (e) => {

                    let items = e.detail;

                    items.forEach(item => {

                        let existente = this.itemsFactura.find(i => i.id === item.id);

                        if (existente) {
                            existente.quantity += item.quantity ?? 1;
                        } else {
                            this.itemsFactura.push({
                                id: item.id,
                                name: item.name,
                                price: item.unitprice,
                                quantity: item.quantity ?? 1
                            });
                        }

                    });

                });

            },
        }
    }
</script>
@endpush
@endsection