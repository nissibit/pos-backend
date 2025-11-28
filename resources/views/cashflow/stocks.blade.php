<div class="card">
    <?php
    $total = $cashflow->store()->sum('quantity');
    $stores = $cashflow->store()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
        <span>
            <a href="{{ route('stock.create', ['id' => $cashflow->id]) }}" class="btn btn-outline-secondary">
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
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $key => $store)
                <?php
                $stock = App\Models\Stock::where('cashflow_id', $cashflow->id)->where('store_id', $store->id)->first();
                ?>
                <tr>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->id.' / ' }}</a></td>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->name }}</a></td>
                    <td><a href="{{ route('stock.show', $stock->id) }}">{{ $store->label }}</a></td>
                    <td class="text-right"><a href="{{ route('stock.show', $stock->id) }}">{{ number_format($store->pivot->quantity ?? 0, 2) }}</a></td>
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
        {{ $stores->appends(request()->input())->links() }}
    </div>
</div>
