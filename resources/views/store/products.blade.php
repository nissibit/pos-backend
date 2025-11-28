<div class="card">
    <?php
    $total = $store->products()->count();
    $products = $store->products()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Abreviatura</th>
                    <th>Preco</th>
                    <th>Taxa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                <tr>
                    <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->id }} </a></td>
                    <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }} </a></td>
                    <td>{{ $product->label }}</td>
                    <td class="text-right">{{ number_format($product->price ?? 0, 2) }}</td>
                    <td>{{ $product->rate }}</td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $products->appends(request()->input())->links() }}
    </div>
</div>
