<div class="card">
    <?php
    $total = $payment->items()->count();
    $items = $payment->items()->latest()->paginate(10);
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
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalQtd = 0;
                $totalPrice = 0;
                $totalSubTotal = 0;
                $totalRate = 0;
                $i = 1;
                ?>
                @forelse($items as $key => $item)
                <tr>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $i }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->quantity }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->unitprice ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->rate ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->subtotal ?? 0, 2) }}</a></td>   
                    <?php
                    $i++;
                    $totalQtd += $item->quantity;
                    $totalPrice += $item->unitprice;
                    $totalRate += ($item->subtotal * $item->rate) / 100;
                    $totalSubTotal += $item->subtotal;
                    ?>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Totais</th>
                    <th class="text-right">{{ number_format($totalQtd,2) }}</th>
                    <th class="text-right">{{ number_format($totalPrice,2) }}</th>
                    <th class="text-right">{{ number_format($totalRate,2) }}</th>
                    <th class="text-right">{{ number_format($totalSubTotal,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $items->appends(request()->input())->links() }}
    </div>
</div>
