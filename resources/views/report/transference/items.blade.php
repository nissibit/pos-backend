<div class="card">
    <?php
    $items = $transference->items()->latest()->get();
    ?>
    <style type="text/css">
        tbody td, thead th{
            border: 1px solid;
        }
    </style>
    <div class="card-body">
        <table  cellspacing="0" cellpadding="2" width="100%" >
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Designacao</th>
                    <th>Qtd.</th>
                    <th>Preco Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                $totalRate = 0;
                $total = 0;
                $i = 1;
                ?>
                @forelse($items as $key => $item)
                @php
                $subtotal = $item->quantity * $item->unitprice;
                $totalRate += $subtotal * $item->rate /100;
                $total += $subtotal + $totalRate;
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unitprice ?? 0, 2) }}</td>
                    <td style="text-align: right;">{{ number_format( $subtotal ?? 0, 2) }}</td>   
                    <?php
                    $i++;
                    ?>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot style="border-bottom: : 0px solid;">
                <tr><th colspan="5">&nbsp;</th></tr>
                <tr>
                    <th colspan="4" style="text-align: right;"> Subtotal</th>
                    <th colspan="1" style="text-align: right;">{{ number_format($subtotal ?? 0, 2) }}</th>
                </tr>                
                <tr>
                    <th colspan="4" style="text-align: right;"> Iva(16%)</th>
                    <th colspan="1" style="text-align: right;">{{ number_format($totalRate ?? 0, 2) }}</th>
                </tr>                
                <tr>
                    <th colspan="4" style="text-align: right;"> Subtotal</th>
                    <th colspan="1" style="text-align: right;">{{ number_format($total ?? 0, 2) }}</th>
                </tr>                
            </tfoot>
        </table>
    </div>

</div>
