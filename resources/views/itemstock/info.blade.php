<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Produto</dt>
            <dd>{{ $itemstock->product->name }}</dd>   
            <dt>Quantidade</dt>
            <dd>{{ number_format($itemstock->quantity, 2) }}</dd>         
            <dt>Preço</dt>
            <dd>{{ number_format($itemstock->product->price ?? 1, 2) }}</dd>
            <dt>Armazem</dt>
            <dd>{{ $itemstock->store->name }}</dd>  
        </dl>
        <form  action="{{ route('itemstock.destroy',$itemstock->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('itemstock_edit')<a href="{{ route('itemstock.edit', $itemstock->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('itemstock_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>