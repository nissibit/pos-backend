<?php
$total = $factura->items()->count();
$items = $factura->items()->latest()->get();
?>
<table border="0" cellspacing="0" cellpadding="1" width="100%">
    <tr>
        <td colspan="2"><strong>Data:</strong><?php echo $factura->day->format('d-m-Y'); ?></td>
        <td colspan="2" style="text-align: right; "><strong>Pagt.:&nbsp;</strong><?= $payment->nr ?></td>
    </tr>    
    <tr>
        <td colspan="4"><strong>Cliente: </strong>{{ $factura->customer_name }}</td>
    </tr>
    <tr>
        <td colspan="4"><strong>NUIT: </strong>{{ $factura->customer_nuit }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Morada: </strong>{{ $factura->customer_address }}</td>
        <td colspan="2" style="text-align: left"><strong>Tel: </strong>{{ $factura->customer_phone }}</td>

    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <br />
    <tbody style="border-bottom: 1px dashed; border-top: 1px dashed;">
        <tr style="border-botton: 1px dashed;">                    
            <th>Qtd.</th>
            <th>Designaçao</th>
            <th style="text-align: center;">Pr.Unt.</th>
            <th style="text-align: center;">Total</th>
        </tr>
    </tbody>

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
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->name }}</td>
            <td style="text-align:center">{{ number_format($item->unitprice ?? 0, 2) }}</td>
            <td style="text-align:right">{{ number_format($item->subtotal ?? 0, 2) }}</td>   
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
            <td colspan="4" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr><th colspan="4">&nbsp;</th></tr>
        <tr>
            <th colspan="2">&nbsp;</th>
            <th style="text-align:right">Subtotal</th>
            <th style="text-align:right">{{ number_format($factura->subtotal,2) }}</th>
        </tr>
        <tr>
            <th colspan="2">&nbsp;</th>
            <th style="text-align:right">Desconto</th>
            <th style="text-align:right">{{ number_format($factura->discount ?? 0,2) }}</th>
        </tr>
        <tr>
            <th colspan="2">&nbsp;</th>
            <th style="text-align:right">IVA(16%)</th>
            <th style="text-align:right">Incluido</th>
        </tr>
        
        <tr>
            <th colspan="2">&nbsp;</th>
            <th style="text-align:right">Total</th>
            <th style="text-align:right">{{ number_format($factura->total ?? 0 ,2) }}</th>
        </tr>
    </tfoot>
</table>
