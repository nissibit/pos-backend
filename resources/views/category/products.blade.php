<div class="col">
    <div class="card">
        <?php
        $total = $category->products()->count();
        $products = $category->products()->latest()->paginate(10);
        ?>
        <div class="card-header">
            {{ "Total :#".$total }}
            <a href="{{ route('report.category.products', $category->id) }}" class="btn btn-secondary">
                <i class="fa fa-print"></i>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive-sm table-sm">
                <thead>
                    <tr>
                        <th>Cod Barras</th>
                        <th>Nome</th>
                        <th>Preco</th>
                        <th>Taxa (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key => $product)
                    <tr>
                        <td><a href="{{ route('product.show', $product->id) }}">{{ $product->barcode != '' ? $product->barcode: $product->othercode }}</a></td>
                        <td><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></td>
                        <td class="text-right"><a href="{{ route('product.show', $product->id) }}">{{ number_format($product->price ?? 0, 2) }}</a></td>
                        <td class="text-right"><a href="{{ route('product.show', $product->id) }}">{{ $product->rate }}</a></td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-center">
            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>
</div>
