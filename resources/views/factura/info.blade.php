<div class="card">
    <div class="card-body">
        <div class="row">
            <dl class="dl-horizontal">
                <dt>Nome do Cliente</dt>
                <dd>{{ $factura->customer_name }}</dd>
                <dt>NUIT</dt>
                <dd>{{ $factura->customer_nuit }}</dd>
                <dt>Contacto</dt>
                <dd>{{ $factura->customer_phone }}</dd>                   
                <dt>Morada</dt>
                <dd>{{ $factura->customer_address }}</dd>                   
                <dt>Subtotal (%)</dt>
                <dd>{{ number_format($factura->subtotal+$factura->totalrate ?? 0, 2) }}</dd>            
                <dt>Desconto</dt>    
                <dd>{{ number_format($factura->discount ?? 0, 2) }}</dd>            
                <dt>Total (%)</dt>
                <dd>{{ number_format($factura->total ?? 0, 2) }}</dd>            
            </dl>
        </div>
        <div class="row col">            
            @if($factura->payed)
            <a href="{{ route('report.factura', $factura->payments->first()->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> </i>
            </a>
            @endif 
            <a href="{{ route('factura.copy', ['id' => $factura->id]) }}" class="btn btn-primary"><i class="fas fa-copy"> </i></a> &nbsp;
            &nbsp;
            @can('audit_factura')
            <form role='form' action="{{ route('audit.entity') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $factura->id }}"  />
                <input type="hidden" name="model" value="\App\Models\Factura"  />
                <input type="hidden" name="name" value="{{ $factura->customer_name }}"  />
                <button type="submit" class="btn btn-primary">            
                    <i class="fa fa-user-shield"> auditar</i>
                </button>
            </form>
            @endcan

            @can('factura_destroy') 
            @if(!$factura->payed && $factura->destroy_username == null)
            <a class="btn btn-danger ml-2"  data-toggle="collapse" href="#collapseExample" ><i class="fa fa-trash"> </i></a>            
            @else
            <a class="btn btn-outline-danger ml-2 disabled"   href="#" >
                <i class="fas fa-trash fa-spin" aria-hidden="true"> </i>
            </a>            
            @endif
            @endcan
        </div>
        <div class="row">
            @include("factura.destroy")
        </div>
    </div>
</div>