@extends('itemstock.indexItemStock')
@section('content-itemstock')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">
            <i class="fas fa-plus-circle"> Produtos não adicionados ainda</i>
            </div>
        </div>
        
    </div>
    <div class="card-body">

        <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th>Cod. Barras</th>
                    <th>Designação</th>
                    <th>Abreviatura</th>
                    <th>Preco</th>
                    <th>Categoria</th>
                    <th>Unidade</th>
                    <th>Adicionar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->barcode }} </a></td>
                    <td><a href="{{ route('product.show', $product->id) }}"> {{ $product->name }} </a></td>
                    <td><a href="{{ route('product.show', $product->id) }}"> {{ \App\Base::strPart($product->label) }} </a></td>
                    <td class="text-right">{{ number_format($product->price ?? 0, 2) }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->unity->name }}</td>
                    <td class="btn-group-sm text-center">
                        <a href="{{ route('itemstock.create', ['id' => $product->id]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-right"></i>
                        </a> 
                    </td>
                </tr> 
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center" colspan="7">  {{ $products->appends(request()->input())->links() }} </td>
                </tr>       
            </tfoot>
        </table> 
    </div>
</div>
@endsection
