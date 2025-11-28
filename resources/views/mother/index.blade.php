@extends("mother.indexMother")
@section("content-product")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>Cod. Barras</th>
            <th>Designação</th>
            <th>Abreviatura</th>
            <th>Stock</th>
            <th>Categoria</th>
            <th>Unidade</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td><a href="{{ route('mother.show', $product->id) }}"> {{ $product->barcode }} </a></td>
            <td><a href="{{ route('mother.show', $product->id) }}"> {{ $product->name }} </a></td>
            <td><a href="{{ route('mother.show', $product->id) }}"> {{ \App\Base::strPart($product->label) }} </a></td>
            <td class="text-right"><a href="{{ route('mother.show', $product->id) }}"> {{ number_format($product->stock()->first()->quantity ?? 0, 2) }}</a></td>
            <td><a href="{{ route('mother.show', $product->id) }}"> {{ $product->category->name }}</a></td>
            <td><a href="{{ route('mother.show', $product->id) }}"> {{ $product->unity->name }}</a></td>
           
        </tr> 
        @empty
        <tr>
            <td colspan="7" class="text-center">
                Sem registos ...
            </td>
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