<div class="card">
    <?php
    $total = $creditnote->items()->count();
    $items = $creditnote->items()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>item</th>
                    <th>Produto</th>
                    <th>Qtd.</th>
                    <th>Preco Unitario</th>
                    <th>Taxa (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal  = 0; ?>
                @forelse($items as $key => $item)
                <tr>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->barcode }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->quantity }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->unitprice ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->rate ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->unitprice*$item->quantity ?? 0, 2) }}</a></td>                    
                </tr>
                <?php
                $subtotal += $item->unitprice*$item->quantity;
                ?>
                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Total</th>
                    <th class="text-right">{{ number_format($subtotal*1.16,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $items->appends(request()->input())->links() }}
    </div>
</div>
