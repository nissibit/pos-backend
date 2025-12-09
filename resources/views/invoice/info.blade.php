<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Fornecedor</dt>
            <dd>{{ $invoice->account->accountable->fullname ?? 'N/A'}}</dd>
            <dt>Numero da factura</dt>
            <dd>{{ $invoice->number ?? 'N/A' }}</dd>            
            <dt>Subtotal</dt>
            <dd>{{ number_format($invoice->subtotal ?? 0, 2) }}</dd>                    
            <dt>Total de impostos</dt>
            <dd>{{ number_format($invoice->totalrate ?? 0, 2) }}</dd>           
             <dt>Total </dt>
            <dd>{{ number_format($invoice->total ?? 0, 2) }}</dd>            
             <dt>Data da Factura </dt>
            <dd>{{ $invoice->day->format('d-m-Y') ?? '' }}</dd>            
             <dt>Data da operacao </dt>
            <dd>{{ $invoice->created_at->format('d-m-Y') ?? 'N/A' }}</dd>            
        </dl>
       <form  action="{{ route('invoice.destroy',$invoice->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('invoice_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>