<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $runoutsell->name }}</dd>
            <dt>Abreviatura</dt>
            <dd>{{ $runoutsell->label }}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $runoutsell->description }}</dd>
            <dt>Verificar Stock</dt>
            <dd><i class="fas fa-{{$runoutsell->checkStock ? 'check-circle text-success': 'times-circle text-danger' }} fa-2x"></i></dd>
        </dl>
       <form  action="{{ route('runoutsell.destroy',$runoutsell->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('runoutsell_edit')<a href="{{ route('runoutsell.edit', $runoutsell->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('runoutsell_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>