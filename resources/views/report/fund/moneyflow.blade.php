<!DOCTYPE html>
<html>
    <head>
        <title>Relatório de MoneyFlow</title>
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
        $payments = 0;
        $entradas = $fund->moneyflows()->where('type', 'Entrada');
        $saidas = $fund->moneyflows()->where('type', 'Saida');
        $moneyflows = $fund->moneyflows;
        @endphp
        @include('report.head')
        <table border="0" cellspacing="0" cellpadding="1" width="100%"> 

            <tbody style="border-bottom: 1px dashed;"> 
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><th colspan="3">Money Flow Entradas/Saídas</th></tr>
                <tr><td colspan="3"><b>Data:</b> {{ $fund->startime->format('d-m-Y / h:i:s') }}</td></tr>
                <tr><td colspan="3"><b>Caixa: </b>{{ $fund->user->name}}</td></tr>
                <tr><td colspan="3">&nbsp;</tr>
                <tr>
                    <th>Descrição</th>
                    <th>Qtd.</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </tbody>
            <tbody>
                <?php
                $vendas = $fund->initial;
                $totalEntradas = $entradas->sum('amount') ?? 0;
                $totalSaidas = $saidas->sum('amount') ?? 0;
                ?>                
                <tr>
                    <th>Valor Inicial</th>
                    <td style="text-align: left;"> 1  </td>
                    <td style="text-align: right;">{{ number_format($vendas, 2) }}</td>
                </tr>
                 <tr>
                    <th>Reforço</th>
                    <td style="text-align: left;">{{ $entradas->count() }}</td>
                    <td style="text-align: right;">{{ number_format($totalEntradas, 2) }}</td>
                </tr>
                <tr >
                    <th class="left middle">Total</th>
                    <td style=" text-align: left;" class="middle">{{ $entradas->count()  }}</td>
                    <td style="text-align: right;" class="middle right">{{ number_format($totalEntradas+$vendas, 2) }}</td>
                </tr>
                <tr>
                    <th>Saídas</th>
                    <td style="text-align: left;">{{ $saidas->count() }}</td>
                    <td style="text-align: right;">{{ number_format($totalSaidas, 2) }}</td>
                </tr> 
                <tr>
                    <th class="left middle">Valor Líquido</th>
                    <td style="text-align: left;" class="middle">&nbsp;</td>
                    <th style="text-align: right;" class="middle right">{{ number_format($vendas +  $totalEntradas - $totalSaidas, 2) }}</th>
                </tr>
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="1" width="100%"> 
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3"><b>Money Flow</b></td></tr>
            <thead style="border-bottom: 1px dashed; border-top: 1px dashed;"> 
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th style="text-align: right;">Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($moneyflows ?? array() as $moneyflow)
                <tr>
                    <td>{{ $moneyflow->reason ?? 'N/A' }}</td>
                    <td>{{ number_format($moneyflow->amount ?? 0, 2) ?? 'N/A' }}</td>
                    <td style="text-align: right;">{{ $moneyflow->created_at->format('d-m-Y') ?? 'N/A' }}</td>
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