<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <dd>{{ $price->customer_name }}</dd>
            <dt>NUIT</dt>
            <dd>{{ $price->customer_nuit }}</dd>
            <dt>Contacto</dt>
            <dd>{{ $price->customer_phone }}</dd>                   
            <dt>Subtotal (%)</dt>
            <dd>{{ number_format($price->subtotal+$price->totalrate ?? 0, 2) }}</dd>            
            <dt>Desconto</dt>    
            <dd>{{ number_format($price->discount ?? 0, 2) }}</dd>            
            <dt>Total (%)</dt>
            <dd>{{ number_format($price->total ?? 0, 2) }}</dd>            
        </dl>
        <form  action="{{ route('price.destroy',$price->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('price_edit')<a href="{{ route('price.edit', $price->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('price_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>