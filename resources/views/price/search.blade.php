@extends("price.indexPrice")
@section("content-price")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Nome</th>
            <th>Preço de Compra</th>
            <th>Margem</th>
            <th>Preço Actual</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @forelse($prices as $key => $price)
        <?php
        $product = $price->product;        
        ?>
        @if($product != null)
        <tr>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->barcode }}</a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }}</a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ number_format($price->buying, 2) }}</a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ number_format($price->margen, 2) }}</a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ number_format($price->current, 2) }}</a></td>
            <td><a href="{{ route('product.show', $product->id) }}"> {{ $price->created_at->format("d-m-Y") ?? 'N/A' }}</a></td>
        @endif
        @empty 
        <tr>
            <td colspan="6" class="text-center"> Sem registos ...</a></td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center"> 
                {{ $prices->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection