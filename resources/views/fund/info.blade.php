<br />
<dl class="dl-horizontal">
    <div class="row">
        <div class="col">
            <dt>Utilizador</dt>
            <dd>{{ $fund->user->name }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>Hora da abertura</dt>
            <dd>{{ $fund->startime ?? 'N/A' }}</dd>
        </div>
        <div class="col">
            <dt>Hora do Fecho</dt>
            <dd>{{ $fund->endtime ?? 'N/A' }}</dd>
        </div>    
    </div>
    <div class="row">
        <div class="col">
            <dt>Valor Inicial (MT)</dt>
            <dd>{{ number_format($fund->initial ?? 0, 2) }}</dd> 
        </div>
        <div class="col">
            <dt>Valor do fundo (MT)</dt>
            <dd>{{ number_format($fund->present ?? 0, 2) }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>Valor Informado (MT)</dt>
            <dd>{{ number_format($fund->informed ?? 0, 2) }}</dd> 
        </div>
        <div class="col">
            <dt>Diferença (MT)</dt>
            <dd>{{ number_format($fund->missing ?? 0, 2) }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>Descrição</dt>
            <dd>{{ $fund->description ?? 'N/A' }}</dd>
        </div>
    </div>
    <div class="row">
        @if($fund->endtime != null)
        <a href="{{ route('fund.print', ['id' => $fund->id]) }}" class="btn btn-outline-danger ">
            <i class="fa fa-print"> </i>
        </a> 
        @else
        <a href="{{ route('fund.edit', $fund->id) }}" class="btn btn-primary">
            <i class="fas fa-boxes"> fechar fundo</i>
        </a>
        @endif

        <form  action="{{ route('fund.destroy',$fund->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                @can('cashflow_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Fundo?" class="btn btn-danger ml-2"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</dl>
