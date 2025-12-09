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
                <div style="width: 35%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:35%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: left; border-radius: 5px;">
                    <div><strong>Exmo. (s) Sr.(s)</strong></div>
                    <div>{{ $quotation->customer_name }}</div><br />
                    <div><strong>Endereço</strong>: {{ $quotation->customer_address ?? '' }}</div>
                    <div><strong>TEL</strong> : {{ $quotation->customer_phone }}</div>
                    <div><strong>NUIT</strong>: {{ $quotation->customer_nuit }}</div>
                </div>
                <div style="width:20%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong>Cotação</strong></div>
                    <div>
                        {{ 'Nr.'.$quotation->nr }}
                    </div><br />
                    <div><strong>Data: </strong> {{ $quotation->day->format('d-m-Y') }}</div>
                </div>              
            </div>
            <div style="clear: both;"></div>
        </header>
        <!-- Define header and footer blocks before your content -->  
        <footer>
            <div style="width: 100%; padding: 0.1em">
                <div style="width:60%; text-align: left; padding: 0.5em; border: 0px solid; float: left; border-radius: 5px;">
                    <div><strong>Valor por extenso: </strong> {{ $quotation->extenso }}</div>
                    <div><strong>Detalhes Bancários</strong></div>
                    <div><strong>NIB: 004300000001498260658  | Conta: 14982606 &nbsp;&nbsp;| Nedbank</strong></div>
                    <div><strong>NIB: 000100000048380622257  | Conta: 483806222 | BIM</strong></div>
                    <div style="font-size: 8pt; margin-top: 0.2em">

                        <span>Esta cotação é válida por 3 dias e os valores inseridos são válidos somente para a mesma.</span><br />
                        <span>Os preços poderão sofrer alterações sem aviso prévio.</span>
                    </div>
                </div>
                <div style="width:30%; text-align: right; padding: 0.2em; border: 0px solid; float: right; border-radius: 5px;">
                    <div style="width: 100%; text-align: right; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px;">
                        @php
                        $subtotal = $quotation->items()->sum('subtotal') ;
                        $subtotalLiquido = $subtotal - $quotation->discount;
                        $iva1 = $subtotalLiquido* 0.16;
                        $total = $subtotalLiquido;
                        @endphp
                        <table style="width: 100%">
                            <tr>
                                <th style="text-align: right;">Sub Total</th>
                                <th style="text-align: right;">{{ number_format($subtotal ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Desconto</th>
                                <th style="text-align: right;">{{ number_format(($quotation->discount) ?? 0,2) }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">IVA (16%)</th>
                                <th style="text-align: right;">Incluído</th>
                            </tr>

                            <tr>
                                <th style="text-align: right;">TOTAL</th>
                                <th style="text-align: right;">{{ number_format(round($total) ?? 0,2) }}</th>
                            </tr>                           
                        </table>
                    </div>
                    <div style="clear: both;">

                    </div>
                </div>
            </div>
        </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main id="main" >
            @php
            $items = $quotation->items()->latest()->get();
            @endphp
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;">
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
        <!--End Main-->

        <script type="text/php">
            if (isset($pdf)) {
            $text = "Pag. {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Baskerville Old Face");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) * 1;
            //            $y = $pdf->get_height() - 35;
            $y = 140;
            $pdf->page_text($x, $y, $text, $font, $size);

            }
        </script>
    </body>
</html>