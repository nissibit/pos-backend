<!DOCTYPE html>
<html>
    <head>
        <title>Relatório de Vendas</title>
        <style type="text/css">
            body{
                font-family: 'arial';
                font-size: 14px;
                margin: 5px auto;
            }
        </style>
    </head>
    <body>
        @include('report.head')
        @php
        $payments = $cashier->payments()->latest()->get();
        @endphp
        <table border="0" cellspacing="0" cellpadding="1" width="100%"> 
            <tbody style="border-bottom: 1px dashed;"> 
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><th colspan="3">Relatório de Vendas</th></tr>
                <tr><td colspan="3"><b>Data:</b> {{ $cashier->endtime == null ? \Carbon\Carbon::now()->format('d-m-Y / h:i:s') : $cashier->endtime->format('d-m-Y / h:i:s') }}</td></tr>
                <tr><td colspan="3"><b>Caixa: </b>{{ $cashier->user->name}}</td></tr>
                <tr>
                    <td colspan="1"><b>Qtd.: </b>{{ $payments->count() }}</td>
                    <td colspan="2" style="text-align: right;"><b>Total: </b>{{ number_format($cashier->paymentItems()->sum('amount'),2) }}</td>
                </tr>
                <tr><td colspan="3">&nbsp;</tr>
                <tr>
                    <th>Nr.</th>
                    <th>Hora</th>
                    <th style="text-align: center;">Total</th>
                </tr>
            </tbody>
            <tbody>
                @forelse($payments ?? array() as $key => $payment)
                <tr>
                    <td>{{ str_pad($payment->factura->id, 4, '0', 0) }}</td>
                    <td>{{ $payment->created_at->format('h:i:s') }}</td>                                
                    <td style="text-align: right">{{ number_format($payment->factura->total ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>s