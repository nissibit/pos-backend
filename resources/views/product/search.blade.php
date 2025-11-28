@extends("product.indexProduct")
@section("content-product")
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>Cod. Barras</th>
            <th>Designação</th>
            <th>Unidade</th>
            <th>Preço</th>
            <!-- <th>Categoria</th> -->
            <!-- <th>Unidade</th> -->
            <th>Adicionar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        @if($product->search)
        <tr>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->barcode }} </a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }} </a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->unity->name }} </a></td>
            <td class="text-right"><a href="{{ route('product.show', $product->id) }}"> {{ number_format($product->price ?? 0, 2) }}</a></td>
            <td class="btn-group-sm text-center">
                <a href="{{ route('product.add', ['id' => $product->id]) }}" class="btn btn-outline-primary">
                    <i class="fa fa-plus"></i>
                </a> 
            </td>
        </tr> 
        @endif     
        @empty
        <tr>
            <td class="text-center text-center" colspan="7"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $products->appends(request()->input())->links() }} </td>
        </tr>       
    </tfoot>
</table> 
@endsection