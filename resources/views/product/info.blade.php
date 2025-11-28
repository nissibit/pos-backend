<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <dl class="dl-horizontal">
                    <dt>Nome</dt>
                    <dd>{{ $product->name ?? 'N/A' }}</dd>
                    <dt>Abreviatura</dt>
                    <dd>{{ $product->unity->name ?? 'N/A'}}</dd>            
                    <dt>Preço</dt>
                    <dd>{{ number_format($product->price ?? 0, 2) ?? 'N/A'  }}</dd>
                    <dt>Taxa</dt>
                    <dd>{{ $product->rate ?? 'N/A'  }}</dd>           
                    <dt>Categoria</dt>
                    <dd>{{ $product->category->name ?? 'N/A'  }}</dd>            
                    <dt>Descrição</dt>
                    <dd>{{ $product->description ?? 'N/A' }}</dd>
                    <hr>
                </dl>
            </div>
            <div class="col">
                @can("delete_product")
                <dt>Preço</dt>
                <dd>{{ number_format($product->price ?? 0, 2) ?? 'N/A'  }}</dd>                
                <dt>Preço de Compra</dt>
                <dd>{{ number_format($product->buying ?? 0, 2) ?? 'N/A'  }}</dd>                
                <dt>Margem de Lucro</dt>
                <dd>{{ number_format($product->margem ?? 0, 2) ?? 'N/A'  }}</dd>
                @endcan
            </div>
        </div>
        <div class="row">
            <?php
            $route_destroy = "mother.destroy";
            $route_edit = "mother.edit";
            ?>
            @if($product->search)
            <a href="{{ route('product.add', ['id' => $product->id]) }}" class="btn btn-outline-primary">
                <i class="fa fa-plus"></i>
            </a> 
            @php
            $route_destroy = "product.destroy";
            $route_edit = "product.edit"; 
            @endphp
            @endif
            &nbsp;
            <form  action="{{ route($route_destroy,$product->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                @can('product_edit')<a href="{{ route($route_edit, $product->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
                @can('product_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
            </form>
        </div>
    </div>
</div>