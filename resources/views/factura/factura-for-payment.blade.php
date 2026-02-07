<div class="w3-card">
    <table class="w3-table-all w3-table-responsive w3-small w3-section">
        <thead>
            <tr>
                <th colspan="4">
                    <label>{{ $facturasHeader ?? '' }}</label>
                    <x-input type="text" placeholder="pesquisar..." oninput="w3.filterHTML('#id01', '.item', this.value)" />
                </th>
            </tr>
            <tr class="w3-theme ">
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>{{ $payed=='true' ? 'Imprimir' : 'Pagar'}}</th>
            </tr>
        </thead>
        <tbody id="id01">
            @forelse($facturas as $key => $factura)
            <tr class="w3-hover-theme item">
                <td>{{ $key + 1 }}</a></td>
                <td>{{ $factura->customer_name }}</a></td>
                <td class="w3-right-align">{{ number_format($factura->total ?? 0, 2) }}</a></td>
                <td>
                    @if($payed == 'true')
                    <x-button data-factura="{{$factura->id}}" class="btnPreviewPayment w3-tiny">
                        <i class="fas fa-print"></i>
                    </x-button>
                    @else
                    <x-button data-factura="{{$factura->id}}" class="btnCreatePayment w3-tiny">
                        <i class="fas fa-arrow-right"> </i>
                    </x-button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center bg-primary text-light text-uppercase"> Sem registos ...</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>