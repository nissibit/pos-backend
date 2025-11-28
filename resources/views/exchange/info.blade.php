<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Moeda</dt>
            <dd>{{ $exchange->currency->name.  ($exchange->currency->sign != null ? ' ('.$exchange->currency->sign.')' : '') }}</dd>
            <dt>Valor</dt>
            <dd>{{ number_format($exchange->amount ?? 0, 2) }}</dd>            
            <dt>Data</dt>
            <dd>{{ $exchange->day->format('d-m-Y') }}</dd>
        </dl>
        <form  action="{{ route('exchange.destroy',$exchange->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('exchange_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>