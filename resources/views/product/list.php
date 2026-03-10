
<div>
    <table class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
        <thead>
            <tr class="w3-theme">
                <th>Cod. Barras</th>
                <th>Designação</th>
                <th>Unidade</th>
                <th>Preço</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr class="w3-hover-theme">
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->barcode }} </a></td>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }} </a></td>
                <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->unity->name }} </a></td>
                <td class="text-right"><a href="{{ route('product.show', $product->id) }}"> {{ number_format($product->price ?? 0, 2) }}</a></td>
            </tr>
            @empty
            <tr>
                <td class="w3-center" colspan="4">
                    Sem registos ...
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>