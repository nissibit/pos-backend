<div>
    <table class="w3-table-all w3-table-responsive w3-small w3-section">
        <thead>
            <tr>
                <th colspan="4">
                    <label>{{ $facturasHeader ?? '' }}</label>
                    <x-input type="text" placeholder="pesquisar..." />
                </th>
            </tr>
            <tr class="w3-theme ">
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>{{ $payed=='true' ? 'Imprimir' : 'Pagar'}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $key => $factura)
            <tr class="w3-hover-theme">
                <td>{{ $key + 1 }}</a></td>
                <td>{{ $factura->customer_name }}</a></td>
                <td class="text-right">{{ number_format($factura->total ?? 0, 2) }}</a></td>
                <td>
                    @if($payed == 'true')
                    <x-link-button href="{{ route('payment.show', $factura->payments()->first() != null ? $factura->payments()->first()->id : 1) }}" class="btn btn-danger ">
                        <i class="fas fa-print"></i>
                    </x-link-button>
                    @else
                    <a href="{{ route('payment.create', ['factura' => $factura->id]) }}" class="btn btn-outline-primary ">
                        <i class="fas fa-arrow-right"> </i>
                    </a>
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