<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Armazem</dt>
            <dd>{{ $stocktaking->store->name }}</dd>   
            <dt>Inicio</dt>
            <dd>{{ $stocktaking->startime->format('d-m-Y h:i') }}</dd>         
            <dt>Termino</dt>
            <dd>{{ $stocktaking->endtime != null ? $stocktaking->endtime ->format('d-m-Y h:i') : 'N/A' }}</dd>
            <dt>Qtd. Produtos</dt>
            <dd>{{ $stocktaking->products != null ? $stocktaking->products->count() : '0' }}</dd>  
        </dl>
        <form  action="{{ route('stocktaking.destroy',$stocktaking->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @if($stocktaking->endtime == null)
            @can('stocktaking_edit')<a href="{{ route('stocktaking.edit', $stocktaking->id) }}" class="btn btn-outline-primary"><i class="fa fa-check-circle"> fechar</i></a> &nbsp;@endcan
            @can('stocktaking_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
            @else
            <a href="{{ route('report.stocktaking.modelo_a4', ['id' =>  $stocktaking->id]) }}" class="btn btn-danger">
                <i class="fas fa-print"> M-A4 </i>
            </a> &nbsp;
            <a href="{{ route('report.stocktaking.modelo_a5', ['id' =>  $stocktaking->id]) }}" class="btn btn-danger">
                <i class="fas fa-print"> M-A5 </i>
            </a>
            @endif
        </form>
    </div>
</div>