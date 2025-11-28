<div class="col">
    <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
        <thead>
            <tr>
                <th>Cod. Barras</th>
                <th>Produto</th>
                <th>Qtd.</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Qtd Min</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)        
            <tr>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->barcode }} </a></td>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }} </a></td>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->stock->first()->quantity }} </a></td>
                <td class="text-right"><a href="{{ route('product.show', $product->id) }}"> {{ number_format($product->price,2) }} </a></td>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->category->name }} </a></td>
                <td class="btn-group-sm text-center">
                    {{ $product->run_out }} 
                </td>
            </tr>         
            @empty
            <tr>
                <td colspan="6" class="text-center">
                    Sem registos ...
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    {{ $products->links() }}
                </td>
            </tr>
        </tfoot>
    </table> 
</div>