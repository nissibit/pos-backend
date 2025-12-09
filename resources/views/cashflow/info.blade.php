<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Utilizador</dt>
            <dd>{{ $cashflow->cashier->user->name ?? 'N/A' }}</dd>
            <dt>Data da Abertura</dt>
            <dd>{{ $cashflow->cashier->startime->format('d-m-Y') ?? 'N/A'}}</dd>            
            <dt>Tipo de Operação</dt>
            <dd>{{ $cashflow->type ?? 'N/A'  }}</dd>
            <dt>Valor</dt>
            <dd>{{ number_format($cashflow->amount ?? 0, 2) ?? 'N/A'  }}</dd>           
            <dt>Motivo</dt>
            <dd>{{ $cashflow->reason ?? 'N/A' }}</dd>
            <dt>Data</dt>
            <dd>{{ $cashflow->created_at->format('d-m-Y').' às '.$cashflow->created_at->format('h:i:s') ?? 'N/A'  }}</dd>            
        </dl>
        <form  action="{{ route('cashflow.destroy',$cashflow->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('cashflow_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>