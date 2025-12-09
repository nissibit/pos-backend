<html>
    <head>
        <title>Lista de Produtos</title>
        <style>
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

        </style>
    </head>
    <body>
        <header>
            <div style="width:100%;">
                <div style="width: 30%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:25%; margin: 0.5em; padding: 0.5em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong style="text-transform: uppercase;">Lista de Produtos</strong></div>

                    <div><strong>Data: </strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</div>
                </div>              
            </div>
            <div style="clear: both;"></div>
        </header>
        <footer>
            <div style="width: 100%; padding: 0em">
                <span>{{ $company->description }}</span><br />
            </div>
        </footer>
        <main id="main">
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;">
                 
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Designação</th>
                        <th>Preço</th>´
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $total = 1;

                    foreach ($products as $product) {
                        ?>
                        <tr>
                            <td> <?php echo $i ?> </a></td>            
                            <td> <?php echo $product->barcode; ?> </a></td>            
                            <td> <?php echo strtoupper($product->name); ?> </a></td>
                            <td style="text-align: right"> <?php echo number_format($product->price ?? 0, 2); ?> </a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table> 
        </main>
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