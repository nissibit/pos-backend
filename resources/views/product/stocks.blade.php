<div class="card">
    <?php
    $total = $product->store()->sum('quantity');
    $stores = $product->store()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
        <span>
            <a href="{{ route('stock.create', ['id' => $product->id]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-plus-circle"> criar</i>
            </a>
        </span>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome do armazem</th>
                    <th>Abreviatura</th>
                    <th>Quantidade</th>
                    <th>Converter</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $key => $store)
                <?php
                $stock = App\Models\Stock::where('product_id', $product->id)->where('store_id', $store->id)->first();
                ?>
                @if($stock!= null)
                <tr>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->id }}</a></td>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->name }}</a></td>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->label }}</a></td>
                    <td class="text-right"><a href="{{ route('stock.show', $stock->id) }}">{{ number_format($store->pivot->quantity ?? 0, 2) }}</a></td>
                    <td class="text-center">
                        <a href="{{ route('product.exchange', ['id' => $stock->id]) }}">
                            <i class="fa fa-cog"></i>
                        </a>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="4" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $stores->appends(request()->input())->links() }}
    </div>
</div>
