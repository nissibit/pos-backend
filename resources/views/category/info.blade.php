<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $category->name }}</dd>
            <dt>Abreviatura</dt>
            <dd>{{ $category->label }}</dd>            
            <dt>Descrição</dt>
            <dd>{{ $category->description }}</dd>
            <dt>Verificar Stock</dt>
            <dd><i class="fas fa-{{$category->checkStock ? 'check-circle text-success': 'times-circle text-danger' }} fa-2x"></i></dd>
        </dl>
       <form  action="{{ route('category.destroy',$category->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('category_edit')<a href="{{ route('category.edit', $category->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('category_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>