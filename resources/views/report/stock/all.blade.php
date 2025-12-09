@include('report.header')
<br />
<div class="card">
    <div class="card-body">
        <table border="1" cellspacing="0" cellpadding="2" width="100%" >
            <tr>
                <th colspan="6">Stock</th>
            </tr>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Armazem</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preco</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $totalQtd = 0;
                $i = 1;
                $totalPreco = 0;
//                dd($stocks);
//                $stocks = $stock->get();
                ?>
                @forelse($stocks as $stock)
                <?php
//                $product = $stock->product;
//                $store = $stock->store;
//                if($product != null && $store != null && $stock != null):
//                
//                $totalQtd += $stock->quantity;
//                $totalPreco += $product->price;
//                $subtotal = $stock->quantity * $product->price;
//                $total += $subtotal;
                ?>
                <tr>
                    <td> {{ $i}} </a></td>            
                    <td> {{ "SEDE" }} </a></td>            
                    <td> {{"Esdon" }} </a></td>
                    <td> {{ number_format($stock->quantity, 2) }} </a></td>
                    <td> {{ number_format(20?? 0, 2) }} </a></td>
                    <td> {{ number_format($subtotal ?? 0, 2) }}</td>
                </tr> 
                <?php 
                
                $i++;
//                endif;
                ?>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
           
        </table>
         <table style="width:100%;">
            <tr>
                <td colspan="3" style="text-align: left">
                    <strong>{{ 'Utilizador: '.auth()->user()->name }}</strong>
                </td>
                <td colspan="3" style="text-align: right; border-left: 0px solid;">
                    <strong>{{ \carbon\Carbon::now()->format('d-m-Y h:m:i') }}</strong>
                </td>
            </tr> 
        </table>
    </div>
</div>