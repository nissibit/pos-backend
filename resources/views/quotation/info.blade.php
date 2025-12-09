<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <dd>{{ $quotation->customer_name }}</dd>
            <dt>quotationo</dt>
            <dd>{{ number_format($quotation->quotation ?? 0, 2) }}</dd>            
            <dt>Debito</dt>
            <dd>{{ number_format($quotation->debit ?? 0, 2) }}</dd>                    
            <dt>Saldo</dt>
            <dd>{{ number_format($quotation->debit ?? 0, 2) }}</dd>           
            <dt>Desconto (%)</dt>
            <dd>{{ number_format($quotation->discount ?? 0, 2) }}</dd>            
        </dl>
        <form  action="{{ route('quotation.destroy',$quotation->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            <a href="{{ route('report.quotation', $quotation->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> </i>
            </a>
            @can('quotation_edit')<a href="{{ route('quotation.edit', $quotation->id) }}" class="btn btn-outline-success"><i class="fas fa-copy"> </i></a> &nbsp;@endcan
            @can('quotation_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>