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
                <div style="width: 70%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:30%; margin: 0.5em; padding: 0.2em; border: 1px solid; float: right; border-radius: 5px; text-align: center;">
                    <div><strong>PEDIDO</strong></div>                    
                   
                </div>              
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            @php
            $items = $factura->items()->latest()->get();
            $subtotal = 0;
            @endphp
            <div style="clear: both"></div>
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <tr>
                    <td colspan="1" style="text-align: left"><strong>Nr. Factura: </strong> {{ str_pad($factura->id,4, '0', 0) }}</td>
                    <td colspan="2" style="text-align: right;"><strong>Data: </strong> {{ $factura->created_at->format('d-m-Y / h:i') }}</td>
                </tr>
                <thead id="thead" style="border: 1px solid; border-radius: 5px;;">
                    <tr>                    
                        <th>Código</th>
                        <th>Designação</th>
                        <th style="text-align: center;">Qtd.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $item)                    
                    <tr>
                        <td>{{ $item->barcode }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                    </tr>                    
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>       
    </body>
</html>