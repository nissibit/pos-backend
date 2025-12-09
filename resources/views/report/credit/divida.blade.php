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

        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="width:100%;">
                <div style="width: 30%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:35%; margin-left: 1em; padding: 1em; border: 1px solid; float: right; border-radius: 5px;">
                    <div><strong>Exmo. (s) Sr.(s)</strong></div>
                    <div>{{ $account->accountable->fullname }}</div><br />
                    <div><strong>Endereço</strong>: {{ $account->accountable->address ?? '' }}</div>
                    <div><strong>TEL</strong> : {{ $account->accountable->phone_nr }}</div>
                    <div><strong>NUIT</strong>: {{ $account->accountable->nuit }}</div>
                </div>             
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $credits = $account->credits()->where('payed', false)->latest()->get();
            $total = 0;
            @endphp
            <div style="clear: both"></div>
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <tr>
                    <td colspan="2" style="text-align: left"><strong>Data: </strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-align: right"><strong>Relatório de Dívidas</strong>
                </tr>
                <thead id="thead" style="border: 1px solid; border-radius: 5px;;">
                    <tr>                    
                        <th>Nr. Requisição</th>
                        <th>Nr. Factura</th>
                        <th>Data</th>
                        <th>Prazo</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($credits as $key => $credit)                    
                    <tr>
                        <td>{{ $credit->nr_requisicao }}</td>
                        <td>{{ $credit->nr_factura }}</td>
                        <td>{{ $credit->day->format('d-m-Y') }}</td>
                        <td>{{ $credit->day->addDays($account->days)->format('d-m-Y') }}</td>
                        <td style="text-align:right; ">{{ number_format($credit->total ?? 0, 2) }}</td>                          
                    </tr>
                    @php
                    $total += $credit->total;
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
                    <div><strong>Detalhes Bancários</strong></div>
                    <div><strong>NIB: 004300000001498260658  | Conta: 14982606 &nbsp;&nbsp;| Banco Único</strong></div>
                    <div><strong>NIB: 000100000048380622257  | Conta: 483806222 | BIM</strong></div>
                    <div style="font-size: 8pt; margin-top: 0.2em">
                        <span>Apelamos que o pagamento seja efectuado dentro do prazo.</span><br />
                    </div>
                </div>                
                <div style="width:30%; text-align: right; margin-top: 1.5em; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">
                    <div style="width: 100%; text-align: right; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px;">                        
                        <table style="width: 100%">                            
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