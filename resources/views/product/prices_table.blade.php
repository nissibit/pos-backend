<div class="card-body">
    <table class="table table-bordered table-hover table-responsive-sm table-sm">
        <thead>
            <tr>
                <th>Preço de Compra</th>
                <th>Margem</th>
                <th>Preço Actual</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @php
            $prices = $product->prices()->latest()->get();
            @endphp
            @forelse($prices as $key => $price)
            <tr>
                <td class="text-right">{{ number_format($price->buying, 2) }}</td>
                <td class="text-right">{{ number_format($price->margen, 2) }}</td>
                <td class="text-right">{{ number_format($price->current, 2) }}</td>
                <td class="text-right">{{ $price->created_at->format("d-m-Y") }}</td>
                @empty 
            <tr>
                <td colspan="4" class="text-center"> Sem registos ...</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>