<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome Completo</dt>
            <dd>{{ $partner->fullname ?? '' }}</dd>
            <dt>Tipo</dt>
            <dd>{{ $partner->type ?? '' }}</dd>            
            <dt>Tel</dt>
            <dd>{{ $partner->phone_nr. '; '.$partner->phone_nr_2 ?? '' }}</dd>            
            <dt>Email</dt>
            <dd>{{ $partner->email ?? 'N/A' }}</dd>            
            <dt>NUIT</dt>
            <dd>{{ $partner->nuit ?? 'N/A' }}</dd>            
            <dt>Tipo de documento</dt>
            <dd>{{ $partner->document_type ?? 'N/A' }}</dd>            
            <dt>Numero do documento</dt>
            <dd>{{ $partner->document_number ?? '' }}</dd>            
            <dt>Telefone & Telefone alternativo</dt>
            <dd>{{ $partner->phone_nr ?? ''}} / {{ $partner->phone_nr_2 }} </dd>                               
            <dt>Endereço</dt>
            <dd>{{ $partner->address ?? 'N/A'}}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $partner->description ?? 'N/A'}}</dd>
        </dl>
        <form  action="{{ route('partner.destroy',$partner->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('partner_edit')<a href="{{ route('partner.edit', $partner->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('partner_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>