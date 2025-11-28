<div class="card">
    <?php
    $total = $server->invoices()->count();
    $invoices = $server->invoices()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Numero</th>
                    <th>Fornecedor</th>
                    <th>Contacto</th>
                    <th>Subtotal</th>
                    <th>Imposto</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $key => $invoice)
                <tr>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->day->format('d-m-Y') }}</a></td>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->account->accountable->fullname }}</a></td>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->account->accountable->phone_nr }}</a></td>
                    <td class="text-right"><a href="{{ route('invoice.show', $invoice->id) }}">{{ number_format($invoice->subtotal ?? 0, 2) }}</a></td>                    
                    <td class="text-right">{{ number_format($invoice->totalrate ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($invoice->total ?? 0, 2) }}</td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    <div class="card-footer text-center">
        {{ $invoices->appends(request()->input())->links() }}
    </div>
</div>
