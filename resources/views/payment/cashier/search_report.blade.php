@extends("payment.cashier.indexCashier")
@section("content-cashier")
<div class="row btn-group-sm">
    <a href="{{ route('report.cashier.resumo.a4', ['from' => $dados['from'], 'to' => $dados['to']]) }}" class="btn btn-danger">
        <i class="fa fa-print"> M-A4 </i>
    </a>  
    &nbsp;
    <a href="{{ route('report.cashier.resumo.a5', ['from' => $dados['from'], 'to' => $dados['to']]) }}" class="btn btn-danger">
        <i class="fa fa-print"> M-A5 </i>
    </a>  
</div>
<div class="row mt-2">
    <table class="table table-bordered table-sm table-responsive-sm" id="todosCashiers">
        <thead>
            <tr>
                <th>@lang('messages.prompt.item')</th>
                <th>@lang('messages.cashier.startime')</th>
                <th>@lang('messages.cashier.present')</th>
                <th>@lang('messages.cashier.informed')</th>
                <th>@lang('messages.cashier.missing')</th>
                <th>@lang('messages.cashier.sales')</th>
                <th>@lang('messages.cashier.inputs')</th>
                <th>@lang('messages.cashier.outputs')</th>
            </tr>
        </thead>
        <tbody> 
            <?php
            $caixas = 0;
            $informados = 0;
            $diferencas = 0;
            $vendas = 0;
            $entradas = 0;
            $saidas = 0;
            $i = 1;
            ?>

            @forelse($cashiers as $cashier)
            <?php
            $caixa = $cashier->present;
            $informado = $cashier->informed;
            $diferenca = $cashier->missing;
            $venda = $cashier->payments->sum('topay');
            $entrada = $cashier->cashflows->where('type', 'Entrada')->sum('amount');
            $saida = $cashier->cashflows->where('type', 'Saida')->sum('amount');

            $caixas += $caixa;
            $informados += $informado;
            $diferencas += $diferenca;
            $vendas += $venda;
            $entradas += $entrada;
            $saidas += $saida;
            ?>
            <tr>
                <td><a href="{{ route('cashier.show', $cashier->id) }}"> {{ $i }}</a></td>            
                <td><a href="{{ route('cashier.show', $cashier->id) }}"> {{ $cashier->startime->format('d-m-Y') }}</a></td>            
                <td style="text-align: right"><a href="{{ route('cashier.show', $cashier->id) }}"> {{ number_format($caixa, 2) }}</a></td>
                <td style="text-align: right"><a href="{{ route('cashier.show', $cashier->id) }}"> {{ number_format($informado, 2) }}</a></td>
                <td style="text-align: right"><a href="{{ route('cashier.show', $cashier->id) }}"> {{ number_format($diferenca, 2) }}</a></td>
                <td style="text-align: right">{{ number_format($venda, 2) }} </td>            
                <td style="text-align: right">{{ number_format($entrada, 2) }} </td>
                <td style="text-align: right">{{ '-'.number_format($saida, 2) }} </td>
            </tr>
            <?php $i++ ?>
            @empty
            <tr>
                <td colspan="8" style="text-align:center">
                    Sem registos ...
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center" colspan="2"> Total</td>
                <th style="text-align: right"> {{ number_format($caixas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($informados ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($diferencas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($vendas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($entradas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ '-'.number_format($saidas ?? 0, 2) }}</th>
            </tr>
        </tfoot>
        <tfoot>
            <tr>
                <td style="text-align: center" colspan="8">
                    {{ $cashiers->appends(request()->input())->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
