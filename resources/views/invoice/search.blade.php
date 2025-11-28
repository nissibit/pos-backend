@extends("invoice.indexInvoice")
@section("content-invoice")
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Data</th>
            <th>Nr. Factura</th>
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
            <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->account->fullname }}</a></td>
            <td><a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->account->phone_nr }}</a></td>
            <td class="text-right"><a href="{{ route('invoice.show', $invoice->id) }}">{{ number_format($invoice->discount ?? 0, 2) }}</a></td>                    
            <td class="text-right">{{ number_format($invoice->balance ?? 0, 2) }}</td>            
        </tr>      
        @empty
        <tr>
            <td class="text-center" colspan="8"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $invoices->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection