<div class="card">
    <?php
    $total = $credit->items()->count();
    $items = $credit->items()->latest()->get();
    ?>

    <div class="card-body">
        <div style="text-align: right">
            <strong>COTACAO: <b style="color: red;"><?php echo str_pad($credit->id, 5, '0', 0) ?> </b></strong>
        </div>
        <table border="1" cellspacing="0" cellpadding="2" width="100%" >
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Designacao</th>
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
                    <td>{{ $i }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unitprice ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->rate ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal ?? 0, 2) }}</td>   
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
                   <th colspan="6">&nbsp;</th>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">{{ number_format($credit->subtotal,2) }}</th>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th class="text-right">Imposto</th>
                    <th class="text-right">{{ number_format($credit->totalrate ?? 0,2) }}</th>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th class="text-right">Desconto</th>
                    <th class="text-right">{{ number_format($credit->discount ?? 0,2) }}</th>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th class="text-right">Total</th>
                    <th class="text-right">{{ number_format($credit->total ?? 0 ,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
