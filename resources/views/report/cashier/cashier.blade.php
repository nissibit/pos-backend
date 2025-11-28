<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                /*margin: 100px 25px;*/
                font-family: 'Baskerville Old Face';
                font-size: 11pt;
            }

            @page {
                margin: 120px 25px 120px 25px;
            }
            main{
                margin-top: 85px;
                border-top: 1px solid;
            }
            header {
                position: fixed;
                top: -90px;
                left: 0px;
                right: 0px;
                width: 100%;
            }
            footer{
                position: fixed; 
                bottom: 0px; 
                left: 0px; 
                right: 0px; 
                border-top: 1px solid;
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
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="width:100%;">
                <div style="width: 40%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:40%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: right; border-radius: 5px;">
                    <div><b>Caixa: </b>{{ $cashier->user->name}}</div>
                    <div><b>Qtd.Vendas: </b>{{ $cashier->payments->count() }}</div>
                    <div><b>Entradas: </b>{{ $cashier->cashflows()->where('type', 'Entrada')->count() }}</div>
                    <div><b>Saidas: </b>{{ $cashier->cashflows()->where('type', 'Saida')->count() }}</div>
                    <div> <b>Hora da abertura: </b>{{ $cashier->startime->format('d-m-Y / h:i:s') ?? 'N/A' }}</div>
                    <div><b>Hora do Fecho: </b>{{ $cashier->endtime->format('d-m-Y / h:i:s') ?? 'N/A' }}</div>
                </div>
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $entradas = $cashier->cashflows()->where('type', 'Entrada');
            $saidas = $cashier->cashflows()->where('type', 'Saida');
            $valor_inicial = $cashier->initial ?? 0;                    
            $valor_vendas = $cashier->payments()->sum('topay') ?? 0;
            $valor_entradas = $entradas->sum('amount') ?? 0;
            $valor_saidas = $saidas->sum('amount') ?? 0;
            $valor_caixa = $cashier->informed;
            $valor_total = $valor_inicial + $valor_vendas+ $valor_entradas;
            $valor_liquido = $valor_total - $valor_saidas;
            $diferenca =  $valor_caixa - $valor_liquido;
            @endphp
            
            <table style="width: 100%; text-align: padding: 5px;" cellspacing="0">
                <tbody>                    
                    <tr>
                        <th style="text-align: left">Valor Inicial</th>
                        <td style="text-align: right;">{{ number_format($valor_inicial, 2) }}</td>         
                    </tr>
                    <tr>
                        <th style="text-align: left">Valor das Vendas</th>
                        <td style="text-align: right;">{{ number_format($valor_vendas, 2) }}</td>        
                    </tr>

                    <tr>
                        <th style="text-align: left">Valor das Entradas</th>
                        <td style="text-align: right;">{{ number_format($valor_entradas, 2) }}</td> 
                    </tr> 
                    <tr>
                        <th style="text-align: left" class="left middle">Total</th>
                        <th style="text-align: right;" class="middle right">{{ number_format($valor_inicial+$valor_vendas+$valor_entradas, 2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: left" Valor das Saidas</th>
                        <td style="text-align: right;">{{ number_format($cashier->cashflows()->where('type', 'Saida')->sum('amount') ?? 0, 2) }}</td> 
                    </tr> 
                    <tr>
                        <th style="text-align: left" class="left middle">Valor Líquido</th>
                        <th style="text-align: right;" class="middle right">{{ number_format($valor_liquido, 2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Valor do Caixa</th>
                        <td style="text-align: right;" >{{ number_format($valor_caixa ?? 0, 2) }}</td> 
                    </tr> 
                    <tr>
                        <th style="text-align: left">Diferença</th>
                        <th style="text-align: right;" class="right left middle">{{ number_format($diferenca ?? 0, 2) }}</th>        
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">Descrição: </th>
                        <td style="text-align: right;">{{ $cashier->description ?? 'N/A' }}</td>        
                    </tr> 
                </tbody>       
            </table>
        </main>
        <!--End Main-->
        <footer>
            <div style="clear:both;"></div>
            <div style="width: 100%; padding: 0.2em">
                <div style="width:60%; text-align: left; padding: 0.3em; border: 0px solid; float: left; border-radius: 5px;">
                    <div style="width: 50%; padding-left: 0.5em; float: left; text-align: center;">
                        <span>Resposável:</span><br /><br />
                        ___________________________<br />
                        (Assinatura, Data)
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div style="width:30%; text-align: right; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">                    
                    <div style="width: 100%;">
                        <table style="width: 100%">                            
                            <tr>
                                <th style="text-align: center;"><b>Usuário</b> : {{ auth()->user()->name }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">{{ \Carbon\Carbon::now()->format('d-m-Y / h:i') }}</th>
                            </tr>                           
                        </table>
                    </div>              
                </div>
            </div>
        </footer>
    </body>
</html>