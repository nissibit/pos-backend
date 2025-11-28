<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <dd>{{ $output->customer_name }}</dd>
            <dt>NUIT</dt>
            <dd>{{ $output->customer_nuit }}</dd>
            <dt>Contacto</dt>
            <dd>{{ $output->customer_phone }}</dd>                   
            <dt>Subtotal (%)</dt>
            <dd>{{ number_format($output->subtotal+$output->totalrate ?? 0, 2) }}</dd>            
            <dt>Desconto</dt>    
            <dd>{{ number_format($output->discount ?? 0, 2) }}</dd>            
            <dt>Total (%)</dt>
            <dd>{{ number_format($output->total ?? 0, 2) }}</dd>            
        </dl>
        <form  action="{{ route('output.destroy',$output->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('output_edit')<a href="{{ route('output.edit', $output->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('output_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>