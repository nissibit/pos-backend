<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Produto Origem</dt>
            <dd><a href="{{ route('product.show', $conversao->stock_from->product->id) }}">{{ $conversao->stock_from->product->name ?? 'N/A' }}</a></dd>
            <dt>Quantidade</dt>
            <dd>{{ number_format($conversao->quantity ?? 0, 2) }}</dd>
            <dt>Retalho</dt>
            <dd>{{ number_format($conversao->flap ?? 0, 2) }}</dd>
            <dt>Produto Destino</dt>
            <dd><a href="{{ route('product.show', $conversao->stock_to->product->id) }}">{{ $conversao->stock_to->product->name ?? 'N/A' }}</a></dd>            
            <dt>Total Recebido</dt>           
            <dd>{{ number_format($conversao->total ?? 0, 2) }}</dd>
            <dt>Data</dt>           
            <dd>{{ $conversao->created_at->format('d-m-Y H:i') }}</dd>
        </dl>
        <form  action="{{ route('conversao.destroy',$conversao->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('conversao_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>