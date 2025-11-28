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
                margin-top: 50px;
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
                bottom: 60px; 
                left: 0px; 
                right: 0px; 
                border-top: 1px solid;
            }
            thead{
                border: 1px solid;
                border-radius: 5px;
            }
            table thead tr:first-child td:first-child {
                border-radius: 0 4px 0 0 ;
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
                <div style="width:40%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: right; border-radius: 5px;">
                    <div><strong>Transferência Nr {{ str_pad($transference->id, 4, '0', 0) }}</strong></div>                    
                    <div><strong>Origigem</strong>: {{ $transference->store_from->name ?? '' }}</div>
                    <div><strong>Destino</strong> : {{ $transference->store_to->name }}</div>
                    <div><strong>Qtd. Produtos</strong>: {{ $transference->items->count() }}</div><div><strong>Data: </strong> {{ $transference->day->format('d-m-Y') }}</div>
                    <div><strong>Data</strong>:  {{ $transference->day->format('d-m-Y') }}</div>
                </div>
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $items = $transference->items()->latest()->get();
            $subtotal = 0;
            @endphp
            <div style="clear: both"></div>
            <table cellspacing="0" cellpadding="1" width="100%" >
                <thead>
                    <tr>                    
                        <th>Código</th>
                        <th>Designação</th>
                        <th>Qtd.</th>
                        <th>P.Unitário</th>
                        <th style="text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)                    
                    <tr>
                        <td>{{ $item->product->barcode }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right; ">{{ number_format($item->unitprice ?? 0, 2) }}</td>
                        <td style="text-align:right; ">{{ number_format($item->unitprice*$item->quantity  ?? 0, 2) }}</td>                          
                    </tr>
                    @php
                    $subtotal += $item->quantity * $item->unitprice;
                    @endphp
                    @empty
                    <tr>
                        <td colspan="5" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
        <!--End Main-->

        <footer>
            <div style="width: 100%; padding: 0.1em">
                <div style="width:60%; text-align: left; padding: 0.2em; border: 0px solid; float: left; border-radius: 5px;">
                    Assinaturas <br />
                    _____________________<br />
                    (O responável : {{ $transference->store_from->name }})
                    <br /><br />
                    _____________________<br />
                    (O responável : {{ $transference->store_to->name }})                 
                </div>
                <div style="width:30%; text-align: right; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">
                    <div style="width: 100%; text-align: right; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px;">
                        @php
                        $total = $subtotal * 1.16;
                        $iva = $$subtotal * 0.16;
                        @endphp
                        <table style="width: 100%">
                            <tr>
                                <th style="text-align: right;">Subtotal</th>
                                <th style="text-align: right;">{{ number_format($subtotal ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">IVA (16%)</th>
                                <th style="text-align: right;">{{ number_format($iva ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">TOTAL</th>
                                <th style="text-align: right;">{{ number_format($total ?? 0,2) }}</th>
                            </tr>                           
                        </table>
                    </div>
                    <div style="clear: both;"></div>
                    <div style="width: 100%;">
                        <table style="width: 100%;  text-align: center;">
                            <tr>
                                <td colspan="2">Usuário</strong>: {{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ \Carbon\Carbon::now()->format('d-m-Y / h:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>