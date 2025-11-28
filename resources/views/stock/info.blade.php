<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Produto</dt>
            <dd>
                @if($stock->product->search)
                <a href="{{ route('product.show', $stock->product->id) }}">{{ $stock->product->name }}</a>
                @else
                <a href="{{ route('mother.show', $stock->product->id) }}">{{ $stock->product->name }}</a>
               @endif
            </dd>   
            <dt>Quantidade</dt>
            <dd>{{ number_format($stock->quantity, 2) }}</dd>         
            <dt>Preço</dt>
            <dd>{{ number_format($stock->product->price ?? 1, 2) }}</dd>
            <dt>Armazem</dt>
            <dd>{{ $stock->store->name }}</dd>  
        </dl>
        <form  action="{{ route('stock.destroy',$stock->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('stock_edit')<a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('stock_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>