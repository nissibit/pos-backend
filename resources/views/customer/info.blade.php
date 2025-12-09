<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome Completo</dt>
            <dd>{{ $customer->fullname ?? '' }}</dd>
            <dt>Tipo</dt>
            <dd>{{ $customer->type ?? '' }}</dd>            
            <dt>Tel</dt>
            <dd>{{ $customer->phone_nr. '; '.$customer->phone_nr_2 ?? '' }}</dd>            
            <dt>Email</dt>
            <dd>{{ $customer->email ?? 'N/A' }}</dd>            
            <dt>NUIT</dt>
            <dd>{{ $customer->nuit ?? 'N/A' }}</dd>            
            <dt>Tipo de documento</dt>
            <dd>{{ $customer->document_type ?? 'N/A' }}</dd>            
            <dt>Numero do documento</dt>
            <dd>{{ $customer->document_number ?? '' }}</dd>            
            <dt>Telefone & Telefone alternativo</dt>
            <dd>{{ $customer->phone_nr ?? ''}} / {{ $customer->phone_nr_2 }} </dd>                               
            <dt>Endereço</dt>
            <dd>{{ $customer->address ?? 'N/A'}}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $customer->description ?? 'N/A'}}</dd>
        </dl>
        <form  action="{{ route('customer.destroy',$customer->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('customer_edit')<a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('customer_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>