<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                /*margin: 100px 25px;*/
                font-family: 'Baskerville Old Face';
                font-size: 10pt;
            }

            @page {
                margin: 140px 25px 50px 25px;
            }
            main{
                margin-top: 65px;
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



        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="width:100%;">
                <div style="width: 30%; float: left; flex: 1;">
                    @include('report.head')
                </div>
                <div style="width:35%; margin-left: 0.5em; padding: 1em; border: 1px solid; float: right; border-radius: 5px;">
                    <div><strong>Inventário</strong></div>
                    <div><strong>Início</strong>: {{ $stocktaking->startime->format('d-m-Y h:i') ?? '' }}</div>
                    <div><strong>Fim</strong> : {{ $stocktaking->endtime->format('d-m-Y h:i') }}</div>
                    <div><strong>Observação</strong>: {{ $stocktaking->description }}</div>
                    <div><strong>Produtos Verificaso</strong>: {{ $stocktaking->products->count() }}</div>
                </div>             
            </div>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table style="width: 100%; padding: 2px; font-size: 8pt">
                <thead id="thead" style="border: 1px solid; border-radius: 5px;">
                    <tr>
                        <th>Codigo</th>
                        <th>Nome</th>
                        <th>Qtd</th>
                        <th>Sistema</th>
                        <th>Diferença</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? array() as $key => $product)
                    @php
                    $current =  \App\Models\Stock::where('store_id', $stocktaking->store_id)->where('product_id', $product->product_id)->first();
                    $qtdCurrent = $current != null ? $current->quantity : 0;
                    $diff =  $product->quantity - $qtdCurrent;
                    @endphp                   
                    <tr>
                        <td>{{ $product->product->barcode }}</td>
                        <td>{{ $product->product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $current != null ? $current->quantity : 'N/A' }}</td>
                        <td class="{{ $diff != '0' ? 'text-danger' : 'text-success' }}">{{ $diff}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
        <!--End Main-->
        <footer>
            <div style="width:100%; font-size: 12px;">
                <div style="width: 50%; float:left; ">
                    <strong>{{ 'Impresso por: '.auth()->user()->name }}</strong>
                </div>
                <div style="width: 40%; float: right; text-align: right;">
                    <strong>{{ \Carbon\Carbon::now()->format('d-m-Y').' / '.\Carbon\Carbon::now()->format('h:i:s') }}</strong>        
                </div>
            </div><br />
        </footer>
    </body>
</html>