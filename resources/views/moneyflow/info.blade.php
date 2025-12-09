<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Utilizador</dt>
            <dd>{{ $moneyflow->fund->user->name ?? 'N/A' }}</dd>
            <dt>Data da Abertura</dt>
            <dd>{{ $moneyflow->fund->startime->format('d-m-Y') ?? 'N/A'}}</dd>            
            <dt>Tipo de Operação</dt>
            <dd>{{ $moneyflow->type ?? 'N/A'  }}</dd>
            <dt>Valor</dt>
            <dd>{{ number_format($moneyflow->amount ?? 0, 2) ?? 'N/A'  }}</dd>           
            <dt>Motivo</dt>
            <dd>{{ $moneyflow->reason ?? 'N/A' }}</dd>
            <dt>Data</dt>
            <dd>{{ $moneyflow->created_at->format('d-m-Y').' às '.$moneyflow->created_at->format('h:i:s') ?? 'N/A'  }}</dd>            
        </dl>
        <form  action="{{ route('moneyflow.destroy',$moneyflow->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('moneyflow_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>