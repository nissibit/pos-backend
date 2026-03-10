<div>
    <div class="w3-container w3-card w3-round-large w3-border w3-border-theme">
        <div class="w3-flex" style="gap: 4px; align-items: center; justify-content: space-between;">
            <div class="w3-left">
                <h2><i class="fas fa-user"></i> Cliente</h2>
                <ul class="w3-ul">
                    <li class="w3-bar">
                        <span><b>Nome</b>: </span>
                        <span>{{$factura->customer_name ?? ''}}</span>
                    </li>
                    <li class="w3-bar">
                        <span><b>Tel</b>: </span>
                        <span>{{$factura->customer_phone ?? ''}}</span>
                    </li>
                    <li class="w3-bar">
                        <span><b>NUIT</b>: </span>
                        <span>{{$factura->customer_nuit ?? ''}}</span>
                    </li>
                    <li class="w3-bar">
                        <span><b>Morada</b>: </span>
                        <span>{{$factura->customer_address ?? ''}}</span>
                    </li>
                </ul>
            </div>
            <div class="w3-center">
                <h2><i class="fas fa-dolar-sign"></i> Pagamento</h2>
                <span><i class="fas fa-{{$factura->payed ? 'check-circle w3-text-green' : 'times-circle w3-text-red'}} fa-2x"></i></span>

            </div>
        </div>
    </div>
    <div class="w3-container w3-card w3-border w3-border-theme w3-round-large w3-section">
        <table class="w3-table-all w3-table-responsive w3-small w3-section">
            <thead>
                <tr class="w3-hover-theme">
                    <th>#</th>
                    <th>Code</th>
                    <th>Designaçao</th>
                    <th>Qtd.</th>
                    <th>Pr.Unt.</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factura->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->barcode }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unitprice ?? 0, 2) }}</td>
                    <td>{{ number_format($item->subtotal ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Total</th>
                    <th>{{ number_format($factura->total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>