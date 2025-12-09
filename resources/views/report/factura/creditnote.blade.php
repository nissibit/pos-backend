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
                margin: 140px 25px 110px 25px;
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
                <div style="width: 30%; float: left; border: 0px solid; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:35%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: left; border-radius: 5px;">
                    <div><strong>Exmo. (s) Sr.(s)</strong></div>
                    <div> {{ $creditnote->payment->payment->acccountable->fullname ?? $creditnote->payment->payment->customer_name ?? 'N/A' }} </div><br />
                    <div><strong>Endereço</strong>: {{ $creditnote->payment->payment->acccountable->address ?? $creditnote->payment->payment->customer_address ?? 'N/A' }}</div>
                    <div><strong>TEL</strong> : {{ $creditnote->payment->payment->acccountable->phone_nr ?? $creditnote->payment->payment->customer_phone ?? 'N/A' }}</div>
                    <div><strong>NUIT</strong>: {{ $creditnote->payment->payment->acccountable->nuit ?? $creditnote->payment->payment->customer_nuit ?? 'N/A' }}</div>
                </div>
                <div style="width:25%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong>Nota de Crédito </strong></div>
                    <div>
                        {{ 'Nr.'.str_pad($creditnote->id, 4, '0', 0) }}
                    </div><br />
                    <div><strong>Data: </strong> {{ $creditnote->created_at->format('d-m-Y') }}</div>
                </div>              
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $items = $creditnote->items()->latest()->get();
            $subtotal = 0;
            @endphp
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;;">
                <!-- <thead> -->
                    <tr>                    
                        <th>Código</th>
                        <th>Designação</th>
                        <th style="text-align: center;">Qtd.</th>
                        <th style="text-align: right;">P.Unitário</th>
                        <th style="text-align: right;">Imposto(%)</th>
                        <th style="text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)  
                    @php
                    $sub = $item->quantity * $item->unitprice;
                    $subtotal += $sub;
                    @endphp
                    <tr>
                        <td>{{ $item->product->barcode }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right; ">{{ number_format($item->unitprice ?? 0, 2) }}</td>
                        <td style="text-align:right; ">{{ number_format($item->rate ?? 0, 2) }}</td>
                        <td style="text-align:right; ">{{ number_format($sub*1.16  ?? 0, 2) }}</td>                          
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
        <?php $extenso = ""; ?>
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
                        @php
                        $total = $subtotal * 1.16;
                        $iva = $subtotal * 0.16;
                        @endphp
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
        <script type="text/php">
            if (isset($pdf)) {
            $text = "pag. {PAGE_NUM} / {PAGE_COUNT}";
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