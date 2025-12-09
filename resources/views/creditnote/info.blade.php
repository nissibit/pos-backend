<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <dd><strong>{{ $creditnote->payment->payment->acccountable->fullname ?? $creditnote->payment->payment->customer_name ?? 'N/A' }}</strong></dd>
            <dt>Nr de Pagamento.</dt>
            <dd>{{ $creditnote->payment->id }}</dd>
            <dt>Contacto</dt>
            <dd>{{ $creditnote->customer_phone }}</dd>                   
            <dt>Total da Nota</dt>
            <dd>{{ number_format($creditnote->total ?? 0, 2) }}</dd>            
            <dt>Total (%)</dt>
            <dd>{{ number_format($creditnote->total ?? 0, 2) }}</dd>            
        </dl>
        <form  action="{{ route('creditnote.destroy',$creditnote->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @if($creditnote->payed)
            <a href="{{ route('report.creditnote', $creditnote->payments->first()->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> </i>
            </a>
            
            @endif
            @can('creditnote_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
           
         </form>
    </div>
</div>