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
                margin: 140px 25px 50px 25px;
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

                <div style="width:25%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong>Produtos Vendidos</strong></div><br />
                    <div><b>Inicio: </b>{{ $cashier->startime->format('d-m-Y / h:i') ?? 'N/A' }}</div>
                    <div><b>Fim: </b>{{ $cashier->endtime == null ? \Carbon\Carbon::now()->format('d-m-Y / h:i') : $cashier->endtime->format('d-m-Y / h:i') ?? 'N/A' }}</div>

                </div>    
            </div>
            <div style="clear: both;"></div>
        </header>

        <footer>
            <div style="width:100%; border: 1px solid;">
                <div style="width: 50%; text-align: left; float: left;">Impresso por: {{ auth()->user()->name }}</div>
                <div style="width: 40%; text-align: right; float: right;">Data: {{ \Carbon\Carbon::now()->format('d-m-Y / h:i:s')}}</div>
            </div>
        </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <?php
            $items = \App\Models\Item::with('product')->whereDate('created_at', $cashier->startime)
                    ->groupBy('product_id')
                    ->orderBy('name', 'ASC')
                    ->get(array(
                DB::raw('product_id as product_id'),
                DB::raw('SUM(unitprice) as "unitprice"'),
                DB::raw('SUM(rate) as "rate"'),
                DB::raw('SUM(subtotal) as "total"'),
                DB::raw('SUM(quantity) as "qtd"'),
                DB::raw('COUNT(*) as "vendas"')
            ));
            ?>
            <div class="card">
                <div class="card-body"> 
                    <table style="width: 100%; padding: 2px; font-size: 8pt">
                        <thead id="thead" style="border: 1px solid; border-radius: 5px;;">

                            <tr>
                                <th>Cod.</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($items as $item)
                            <?php
                            $product = \App\Models\Product::find($item->product_id);
                            ?>
                            @if($product != null)
                            <tr>
                                <td>{{ $item->product->barcode }} </td>
                                <td>{{ $item->product->name }} </td>
                                <td>{{ $item->qtd }} </td>
                                <td class="text-right">{{ number_format(round($item->unitprice/$item->vendas*1.16),2) }} </td>
                                <td class="text-right">{{ number_format($item->total,2) }} </td>

                            </tr> 
                            @endif
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Sem registos ...
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table> 
                </div>
            </div>
        </main> 


        <script type="text/php">
            if (isset($pdf)) {
            $text = "pag. {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Baskerville Old Face");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;

            $pdf->page_text($x, $y, $text, $font, $size);

            }
        </script>
    </body>
</html>