<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                /*margin: 100px 25px;*/
                font-family: 'arial';
                font-size: 14px;
            }

            @page {
                margin: 140px 25px 25px 25px;
            }

            header {
                position: fixed;
                top: -110px;
                left: 0px;
                right: 0px;
                width: 100%;
            }
            main{
                position: relative;
                top: 65px;
            }
            footer {
                position: absolute;
                bottom: 0px;
                border-top: 1px solid;
            }
        </style>
    </head>
    <body>

        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="width:100%;">
                <div style="width: 40%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:40%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: right; border-radius: 5px;">
                    <div><b>Resumo do Fundo de Maneio </b></div>
                    <br />
                    <div><b>Período </b>{{ $dados['from']." / ".$dados['to'] }}</div>
                </div>
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;">
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th >Valor Inicial</th>
                        <th >Valor Informado</th>
                        <th >Diferenças</th>
                        <th >Entradas</th>
                        <th >Saídas</th>
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

                    @forelse($funds as $fund)
                    <?php
                    $caixa = $fund->present;
                    $informado = $fund->informed;
                    $diferenca = $fund->missing;
                    $venda = 0;
                    $entrada = $fund->moneyflows->where('type', 'Entrada')->sum('amount');
                    $saida = $fund->moneyflows->where('type', 'Saida')->sum('amount');

                    $caixas += $caixa;
                    $informados += $informado;
                    $diferencas += $diferenca;
                    $vendas += $venda;
                    $entradas += $entrada;
                    $saidas += $saida;
                    ?>
                    <tr>
                        <td> {{ $i }} </td>            
                        <td> {{ $fund->startime->format('d-m-Y') }} </td>            
                        <td > {{ number_format($caixa, 2) }} </td>
                        <td > {{ number_format($informado, 2) }} </td>
                        <td > {{ number_format($diferenca, 2) }} </td>        
                        <td >{{ number_format($entrada, 2) }} </td>
                        <td >{{ number_format($saida, 2) }} </td>
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

            </table>
        </main>
        <!--End Main-->
        <footer>
            <table  style="width: 100%; padding: 0px; font-size: 8pt">
                <tfoot style="border: 1px solid; border-radius: 5px;">
                    <tr>
                        <th style="text-align:center" colspan="2"> Total</td>
                        <th> {{ number_format($caixas ?? 0, 2) }}</th>
                        <th> {{ number_format($informados ?? 0, 2) }}</th>
                        <th style="text-align:right;"> {{ number_format($diferencas ?? 0, 2) }}</th>
                         <th style="text-align:center;"> {{ number_format($entradas ?? 0, 2) }}</th>
                        <th  style="text-align:center;"> {{ number_format($saidas ?? 0, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            <div style="width:100%; font-size: 12px;">
                <div style="width: 50%; float:left; ">
                    <strong>{{ 'Impresso por: '.auth()->user()->name }}</strong>
                </div>
                <div style="width: 40%; float: right; text-align: right;">
                    <strong>{{ \Carbon\Carbon::now()->format('d-m-Y').' / '.\Carbon\Carbon::now()->format('h:i:s') }}</strong>        
                </div>
            </div><br />
        </footer>
    </body>
</html>