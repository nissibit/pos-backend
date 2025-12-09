<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                /*margin: 100px 25px;*/
                font-family: 'arial';
                font-size: 10pt;
            }

            @page {
                margin: 140px 25px 110px 25px;
            }
            main{
                margin-top: 60px;
            }
            header {
                position: fixed;
                top: -110px;
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
            #img{
                top: 87px;
                position: fixed;
                width: 100%;
                height: {{ $height }};
                opacity: 0.2;
            }
        </style>
    </head>
    <body>       
        <img id="img" src='{{ asset("img/bg.jpg") }}'  />
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="width:100%;">
                <div style="width: 30%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:35%; margin-left: 1em; padding: 1em; border: 1px solid; float: left; border-radius: 5px;">
                    <div><strong>Exmo. (s) Sr.(s)</strong></div>
                    <div>{{ $credit->account->accountable->fullname }}</div><br />
                    <div><strong>Endereço</strong>: {{ $credit->account->accountable->address ?? '' }}</div>
                    <div><strong>TEL</strong> : {{ $credit->account->accountable->phone_nr }}</div>
                    <div><strong>NUIT</strong>: {{ $credit->account->accountable->nuit }}</div>
                </div>
                <div style="width:20%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong>CRÉDITO</strong></div>
                    <div>
                        {{ 'Nr.'.$credit->nr }}
                    </div><br />
                    <div><strong>Data: </strong> {{ $credit->day->format('d-m-Y') }}</div>
                </div>              
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $items = $credit->items()->latest()->get();
            $subtotal = 0;
            @endphp
            <div style="clear: both"></div>
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <tr>
                    <td colspan="2" style="text-align: left"><strong>Nr. Requisição: </strong> {{ $credit->nr_requisicao }}</td>
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-align: right"><strong>Nr. Factura: </strong> {{ $credit->nr_factura }}</td>
                </tr>
                <thead id="thead" style="border: 1px solid; border-radius: 5px;;">
                    <tr>                    
                        <th>Código</th>
                        <th>Designação</th>
                        <th style="text-align: center;">Qtd.</th>
                        <th style="text-align: right;">P.Unitário</th>
                        <th style="text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)                    
                    <tr>
                        <td>{{ $item->barcode }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right; ">{{ number_format($item->unitprice ?? 0, 2) }}</td>
                        <td style="text-align:right; ">{{ number_format($item->unitprice*$item->quantity  ?? 0, 2) }}</td>                          
                    </tr>
                    @php
                    $subtotal += $item->quantity * $item->unitprice;
                    @endphp
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
        <!--End Main-->

        <footer>
            <div style="width: 100%; padding: 0.1em">
                <div style="width:60%; text-align: left; padding: 0.5em; border: 0px solid; float: left; border-radius: 5px;">
                    <div><strong>Valor por extenso: </strong> {{ $credit->extenso }}</div>
                    <div><strong>Detalhes Bancários</strong></div> 
                    <div><strong>NIB: 004300000001498260658  | Conta: 14982606 &nbsp;&nbsp;| Banco Único</strong></div>
                    <div><strong>NIB: 000100000048380622257  | Conta: 483806222 | BIM</strong></div>
                    <div style="font-size: 8pt; margin-top: 0.2em">                        
                        <span>Esta cotação é válida por 7 dias e os valores inseridos são válidos somente para a mesma.</span><br />
                        <span>Os preços poderão sofrer alterações sem aviso prévio.</span>
                    </div>
                </div>                
                <div style="width:30%; text-align: right; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">
                    <div style="width: 100%; text-align: right; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px;">
                        @php
                        $total = $subtotal ;
                        $iva = $subtotal * 0.16;
                        @endphp
                        <table style="width: 100%">
                            <tr>
                                <th style="text-align: right;">Subtotal</th>
                                <th style="text-align: right;">{{ number_format($subtotal ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">IVA (16%)</th>
                                <th style="text-align: right;">Incluído</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Desconto</th>
                                <th style="text-align: right;">{{ number_format($credit->discount ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">TOTAL</th>
                                <th style="text-align: right;">{{ number_format($total ?? 0,2) }}</th>
                            </tr>                           
                        </table>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>