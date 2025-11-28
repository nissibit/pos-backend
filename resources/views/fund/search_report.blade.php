@extends("fund.indexFund")
@section("content-fund")
<div class="row btn-group-sm">
    <a href="{{ route('report.fund.resumo', ['from' => $dados['from'], 'to' => $dados['to'], 'm' => 'a4']) }}" class="btn btn-danger">
        <i class="fa fa-print"> M-A4 </i>
    </a>  
    &nbsp;
    <a href="{{ route('report.fund.resumo', ['from' => $dados['from'], 'to' => $dados['to'], 'm' => 'a5']) }}" class="btn btn-danger">
        <i class="fa fa-print"> M-A5 </i>
    </a>  
</div>
<div class="row mt-2">
    <table class="table table-bordered table-sm table-responsive-sm" id="todosFunds">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Valor Inicial</th>
                <th>Valor Informado</th>
                <th>Diferenças</th>
                <th>Entradas</th>
                <th>Saídas</th>
            </tr>
        </thead>
        <tbody> 
            <?php
            $fundos = 0;
            $informados = 0;
            $diferencas = 0;
            $vendas = 0;
            $entradas = 0;
            $saidas = 0;
            $i = 1;
            ?>

            @forelse($funds as $fund)
            <?php
            $fundo = $fund->initial;
            $informado = $fund->informed;
            $diferenca = $fund->missing;
            $venda = 0;
            $entrada = $fund->moneyflows->where('type', 'Entrada')->sum('amount');
            $saida = $fund->moneyflows->where('type', 'Saida')->sum('amount');

            $fundos += $fundo;
            $informados += $informado;
            $diferencas += $diferenca;
            $vendas += $venda;
            $entradas += $entrada;
            $saidas += $saida;
            ?>
            <tr>
                <td><a href="{{ route('fund.show', $fund->id) }}"> {{ $i }}</a></td>            
                <td><a href="{{ route('fund.show', $fund->id) }}"> {{ $fund->startime->format('d-m-Y') }}</a></td>            
                <td style="text-align: right"><a href="{{ route('fund.show', $fund->id) }}"> {{ number_format($fundo, 2) }}</a></td>
                <td style="text-align: right"><a href="{{ route('fund.show', $fund->id) }}"> {{ number_format($informado, 2) }}</a></td>
                <td style="text-align: right"><a href="{{ route('fund.show', $fund->id) }}"> {{ number_format($diferenca, 2) }}</a></td>
                <td style="text-align: right">{{ number_format($entrada, 2) }} </td>
                <td style="text-align: right">{{ '-'.number_format($saida, 2) }} </td>
            </tr>
            <?php $i++ ?>
            @empty
            <tr>
                <td colspan="7" style="text-align:center">
                    Sem registos ...
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center" colspan="2"> Total</td>
                <th style="text-align: right"> {{ number_format($fundos ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($informados ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($diferencas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ number_format($entradas ?? 0, 2) }}</th>
                <th style="text-align: right"> {{ '-'.number_format($saidas ?? 0, 2) }}</th>
            </tr>
        </tfoot>
        <tfoot>
            <tr>
                <td style="text-align: center" colspan="8">
                    {{ $funds->appends(request()->input())->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
