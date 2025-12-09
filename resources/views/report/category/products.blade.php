@include('report.header')
<style>
    body{
        font-family: 'arial';
        font-size:11px;
    }
</style>
<div class="card">
    <?php
    $total = $category->products()->count();
    $products = $category->products()->get();
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table border="1" cellspacing="0" cellpadding="2" width="100%" >
            <thead>
                <tr>
                    <th colspan="6">Produtos da categoria <strong>{{ $category->name }}</strong></th>
                </tr>
                <tr>
                    <th>Item</th>
                    <th>Cod Barras</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Taxa</th>
                    <th>Descriçao</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @forelse($products->sortBy('name') as $key => $product)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $product->barcode != '' ? $product->barcode: $product->othercode }}</td>
                    <td>{{ $product->name }}</td>
                    <td style="text-align: right">{{ number_format($product->price ?? 0, 2) }}</td>
                    <td style="text-align: right">{{ $product->rate }}</td>
                    <td>{{ $product->description }}</td>
                </tr>
                <?php $i++; ?>
                @empty
                <tr>
                    <td colspan="5" class="text-center"> Sem registos ...</td>
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
