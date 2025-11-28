<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Valor</dt>
            <dd>{{ number_format($reinforcement->amount ?? 1, 2) }}</dd>
            <dt>Descrição</dt>
            <dd>{{ $reinforcement->description }}</dd>  
            <dt>Data / Hora</dt>
            <dd>{{ $reinforcement->created_at->format('d-m-Y h:i:s') }}</dd>  
        </dl>
        <form  action="{{ route('reinforcement.destroy',$reinforcement->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}           
            @can('reinforcement_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>