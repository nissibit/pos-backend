<!DOCTYPE html>
<html>
    <head>
        <title>Relatório de CashFlow</title>
        <style type="text/css">
            body{
                font-family: 'arial';
                font-size: 14px;
                margin: 5px auto;
            }
            .middle{
                border-top:  1px solid;   
                border-bottom: 1px solid;   
            }
            .left{
                border-left: 1px solid;
                border-radius: 5px;                
            }
            .right{
                border-right: 1px solid;
                border-radius: 5px;                
            }
        </style>
    </head>
    <body>
        @php
        $payments = $cashier->payments()->latest()->get();
        $entradas = $cashier->cashflows()->where('type', 'Entrada');
        $saidas = $cashier->cashflows()->where('type', 'Saida');
        $cashflows = $cashier->cashflows;
        @endphp
        @include('report.head')
        <table border="0" cellspacing="0" cellpadding="1" width="100%"> 

            <tbody style="border-bottom: 1px dashed;"> 
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><th colspan="3">Relatório de Entradas/Saídas</th></tr>
                <tr><td colspan="3"><b>Data:</b> {{ $cashier->startime->format('d-m-Y / h:i:s') }}</td></tr>
                <tr><td colspan="3"><b>Caixa: </b>{{ $cashier->user->name}}</td></tr>
                <tr><td colspan="3">&nbsp;</tr>
                <tr>
                    <th  style="text-align: left;">Descrição</th>
                    <th  style="text-align: left;">Qtd.</th>
                    <th style="text-align: center;">Total</th>
                </tr>
            </tbody>
            <tbody>
                <?php
                $vendas = $cashier->payments()->sum('topay') ?? 0;
                $totalEntradas = $entradas->sum('amount') ?? 0;
                $totalSaidas = $saidas->sum('amount') ?? 0;
                ?>
                <tr>
                    <th style="text-align: left;">Vendas</th>
                    <td style="text-align: left;">{{ $payments->count() }}</td> 
                    <td style="text-align: right;">{{ number_format($vendas,2) }}</td>
                </tr> 
                <tr>
                    <th style="text-align: left;">Entradas</th>
                    <td style="text-align: left;">{{ $entradas->count() }}</td>
                    <td style="text-align: right;">{{ number_format($totalEntradas, 2) }}</td>
                </tr>
                <tr >
                    <th style="text-align: left;" class="left middle">Total</th>
                    <td style=" text-align: left;" class="middle">{{ $entradas->count() + $payments->count() }}</td>
                    <td style="text-align: right;" class="middle right">{{ number_format($totalEntradas+$vendas, 2) }}</td>
                </tr>
                <tr>
                    <th style="text-align: left;">Saídas</th>
                    <td style="text-align: left;">{{ $saidas->count() }}</td>
                    <td style="text-align: right;">{{ '-'.number_format($totalSaidas, 2) }}</td>
                </tr> 
                <tr>
                    <th style="text-align: left;" class="left middle">Valor Líquido</th>
                    <td style="text-align: left;" class="middle">&nbsp;</td>
                    <th style="text-align: right;" class="middle right">{{ number_format($vendas +  $totalEntradas - $totalSaidas, 2) }}</th>
                </tr>
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="1" width="100%"> 
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3"><b>CashFlow</b></td></tr>
            <thead style="border-bottom: 1px dashed; border-top: 1px dashed;"> 
                <tr>
                    <th colspan="2">Descrição</th>
                    <th style="text-align: center;">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashflows ?? array() as $cashflow)
                <tr>
                    <td colspan="2">{{ $cashflow->reason ?? 'N/A' }}</td>
                    <td style="text-align: right;">{{ ($cashflow->type == 'Entrada' ? '' : '-').number_format($cashflow->amount ?? 0, 2) ?? 'N/A' }}</td>
                </tr> 
                @empty
                <tr>
                    <td colspan="3" style="text-align: center;">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr><td colspan="3">&nbsp;</tr>                
                <tr><td colspan="3">&nbsp;</tr>                
                <tr><td colspan="3">Impresso por: {{ auth()->user()->name }}</tr>                
                <tr><td colspan="3">Data: {{ \Carbon\Carbon::now()->format('d-m-Y / h:i:s')}}</tr>
                <tr><td colspan="3">&nbsp;</tr>                
                <tr><td colspan="3">&nbsp;</tr>    
            </tfoot>
        </table>
    </body>
</html>