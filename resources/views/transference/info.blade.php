<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Armazem origem/destino</dt>
            <dd>{{ ($transference->store_from->name ?? 'N/A').' / '.($transference->store_to->name ?? 'N/A') }}</dd>  
            <dt>Motivo</dt>
            <dd>{{ $transference->motive }}</dd>   
            <dt>Data</dt>
            <dd>{{ $transference->day->format('d-m-Y') }}</dd>         
            <dt>Descricao</dt>
            <dd>{{ $transference->description }}</dd>
        </dl>
        <form  action="{{ route('transference.destroy',$transference->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            <a href="{{ route('transference.print', ['id' => $transference->id]) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> </i>
            </a>
            @can('transference_edit')<a href="{{ route('transference.edit', $transference->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('transference_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>

    </div>
</div>