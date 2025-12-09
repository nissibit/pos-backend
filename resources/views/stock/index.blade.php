@extends("stock.indexStock")
@section("content-stock")
<div class="col text-right">
    <a href="{{ route('report.stock.all') }}" class="btn btn-secondary">
        <i class="fa fa-print"></i>
    </a>
</div>
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>Cod. Barras</th>
            <th>Produto</th>
            <th>Qtd.</th>
            <th>Preço</th>
            <!-- <th>Categoria</th> -->
            <th>Copiar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stocks as $stock)
        <tr>
            <td><a href="{{ route('stock.show', $stock->id) }}"> {{ $stock->product->barcode }} </a></td>
            <td><a href="{{ route('stock.show', $stock->id) }}"> {{ $stock->product->name }} </a></td>
            <td><a href="{{ route('stock.show', $stock->id) }}"> {{ $stock->quantity }} </a></td>
            <td class="text-right"><a href="{{ route('stock.show', $stock->id) }}"> {{ number_format($stock->product->price,2) }} </a></td>
            <td class="btn-group-sm text-center">
                <a href="{{ route('product.add', ['id' => $stock->product->id]) }}" class="btn btn-outline-primary">
                    <i class="fa fa-plus"></i>
                </a> 
            </td>
        </tr> 
        @empty
        <tr>
            <td colspan="5" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <thead>
         <tr>
            <td colspan="5" class="text-center">
               {{ $stocks->links() }}
            </td>
        </tr>
    </thead>
</table> 
@endsection