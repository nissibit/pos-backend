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
            <tbody> 
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><th colspan="3">Relatório de Vendas</th></tr>
                <tr><td colspan="3"><b>Data:</b> {{ $cashier->endtime != null ? $cashier->endtime->format('d-m-Y / h:i:s') : \Carbon\Carbon::now()->format('d-m-Y / h:i:s') }}</td></tr>
                <tr><td colspan="3"><b>Caixa: </b>{{ $cashier->user->name}}</td></tr>
                <tr>
                    <td colspan="1"><b>Qtd.: </b>{{ $payments->count() }}</td>
                    <td colspan="2" style="text-align: right;"><b>Total: </b>{{ number_format($cashier->payments()->sum('topay'),2) }}</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>                
                <tr><td colspan="3">&nbsp;</td></tr>                
                <tr><td colspan="3">Impresso por: {{ auth()->user()->name }}</td></tr>                
                <tr><td colspan="3">Data: {{ \Carbon\Carbon::now()->format('d-m-Y / h:i:s')}}</td></tr>
                <tr><td colspan="3">&nbsp;</tr>                
                <tr><td colspan="3">&nbsp;</tr>                
            </tbody>   
            
        </table>
    </body>
</html>s