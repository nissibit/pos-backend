<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $store->name }}</dd>
            <dt>Abreviatura</dt>
            <dd>{{ $store->label }}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $store->description }}</dd>
        </dl>
        <form  action="{{ route('store.destroy',$store->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('store_edit')<a href="{{ route('store.edit', $store->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('store_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>