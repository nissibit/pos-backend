@extends('stocktaking.indexStockTaking')
@section('content-stocktaking')
<div class="card">
    <div class="card-header">
        <i class="fa fa-check"> Produtos adicionados</i>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Designação</th>
                    <th>Qtd</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                @php
                $current =  \App\Models\Stock::where('store_id', $stocktaking->store_id)->where('product_id', $product->product_id)->first();
                $qtdCurrent = $current != null ? $current->quantity : 0;
                $diff =  $product->quantity - $qtdCurrent;
                @endphp
                @if($stocktaking->endtime == null)
                <tr>
                    <td><a href="{{ route('itemstock.edit', $product->id) }}">{{ $product->product->barcode }}</a></td>
                    <td><a href="{{ route('itemstock.edit', $product->id) }}">{{ $product->product->name }}</a></td>
                    <td><a href="{{ route('itemstock.edit', $product->id) }}">{{ $product->quantity }}</a></td>
                </tr>
                @else
                <tr>
                    <td>{{ $product->product->barcode }}</td>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>

                @endif

                @empty
                <tr>
                    <td colspan="3" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center"> {{ $products->appends(request()->input())->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection