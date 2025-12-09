<div class="card">
    <?php
    $total = $product->items()->where('item_type', 'App\Models\Transference')->count();
    $transferences = $product->items()->where('item_type', 'App\Models\Transference')->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>Qtd.</th>
                    <th>Origem</th>
                    <th>Destino.</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Descricao</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @forelse($transferences as $key => $item)
                <?php $transference = \App\Models\Transference::find($item->item_id); ?>
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $transference->store_from->name ?? 'N/A' }}</td>
                    <td>{{ $transference->store_to->name ?? 'N/A'}}</td>
                    <td>{{ $transference->day ?? 'N/A'  }}</td>
                    <td>{{ $transference->motive ?? 'N/A'}}</td>
                    <td>{{ $transference->description ?? 'N/A' }}</td>
                    <?php $i++; ?>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>            
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $transferences->appends(request()->input())->links() }}
    </div>
</div>
