<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $unity->name }}</dd>
            <dt>Abreviatura</dt>
            <dd>{{ $unity->label }}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $unity->description }}</dd>
        </dl>
        <form  action="{{ route('unity.destroy',$unity->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('unity_edit')<a href="{{ route('unity.edit', $unity->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('unity_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>