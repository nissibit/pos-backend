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
                margin: 140px 25px 115px 25px;
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
                position: fixed;
                bottom: 0px;
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
                <div style="width:35%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: left; border-radius: 5px;">
                    <div><strong>Exmo. (s) Sr.(s)</strong></div>
                    <div>{{ $output->customer_name }}</div><br />
                    <div><strong>Endereço</strong>: {{ $output->customer_address ?? '' }}</div>
                    <div><strong>TEL</strong> : {{ $output->customer_phone }}</div>
                    <div><strong>NUIT</strong>: {{ $output->customer_nuit }}</div>
                </div>
                <div style="width:25%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong style="text-transform: uppercase;">Guia de saída</strong></div>
                    <div>
                        {{ 'Nr.'.$output->nr }}
                    </div><br />
                    <div><strong>Data: </strong> {{ $output->day->format('d-m-Y') }}</div>
                </div>              
            </div>
            <div style="clear: both;"></div>
        </header>
        <footer>
            <div style="width: 100%; padding: 1em">
                <div style="width:60%; text-align: left; padding: 0.3em; border: 0px solid; float: left; border-radius: 5px;">
                    <div style="width: 50%; float: left; text-align: center;">
                        <span>Entregue por:</span><br /><br />
                        ___________________________<br />
                        (Assinatura, Data)
                    </div>
                    <div style="width: 50%; padding-left: 0.5em; float: right; text-align: center;">
                        <span>Recebido por:</span><br /><br />
                        ___________________________<br />
                        (Assinatura, Data)
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div style="width:30%; text-align: right; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">
                    <div style="width: 100%; text-align: right; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px;">

                        <table style="width: 100%">                            
                            <tr>
                                <th style="text-align: right;">TOTAL</th>
                                <th style="text-align: right;">{{ number_format($output->total ?? 0,2) }}</th>
                            </tr>                           
                        </table>
                    </div>                 
                </div>
            </div>
        </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $items = $output->items()->latest()->get();
            $subtotal = 0;
            @endphp
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;;">
                <!-- <thead> -->
                    <tr> 
                        <th style="text-align: left;">Código</th>
                        <th style="text-align: left;">Designação</th>
                        <th style="text-align: center;">Qtd.</th>
                        <th style="text-align: right;">P.Unitário</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)  
                    <?php $price = $item->unitprice; ?>
                    <tr>
                        <td>{{ $item->barcode }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right; ">{{ number_format($price ?? 0, 2) }}</td>
                        <td style="text-align:right; ">{{ number_format($price*$item->quantity  ?? 0, 2) }}</td>                          
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
        <!--End Ma
    </body>
</html>