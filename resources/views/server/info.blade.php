<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome Completo</dt>
            <dd>{{ $server->fullname ?? '' }}</dd>
            <dt>Tipo</dt>
            <dd>{{ $server->type ?? '' }}</dd>            
            <dt>NUIT</dt>
            <dd>{{ $server->nuit ?? '' }}</dd>            
            <dt>Tipo de documento</dt>
            <dd>{{ $server->document_type ?? '' }}</dd>            
            <dt>Numero do documento</dt>
            <dd>{{ $server->document_number ?? '' }}</dd>            
            <dt>Telefone & Telefone alternativo</dt>
            <dd>{{ $server->phone_nr ?? ''}} / {{ $server->phone_nr_2 }} </dd>                               
            <dt>Endereço</dt>
            <dd>{{ $server->address ?? 'N/A'}}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $server->description ?? 'N/A'}}</dd>
        </dl>
        <form  action="{{ route('server.destroy',$server->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('server_edit')<a href="{{ route('server.edit', $server->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('server_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>