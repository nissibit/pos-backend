<div class="card">
    <div class="card-body"> 
        <!-- <a href="{{ route('report.cashier.products', ['id' => $cashier->id, 'm'=> 'a4']) }}" class="btn btn-danger">
            <i class="fa fa-print"> M-A4</i>
        </a> &nbsp;
        <a href="{{ route('report.cashier.products', ['id' => $cashier->id, 'm' => 'a5']) }}" class="btn btn-danger">
            <i class="fa fa-print"> M-A5</i>
        </a> <br /> -->
        <span># Produtos: {{$products->count()}}</span>
        <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('messages.product.barcode')</th>
                    <th>@lang('messages.entity.product')</th>
                    <th>@lang('messages.item.quantity')</th>
                    <th>@lang('messages.product.price')</th>
                    <th>@lang('messages.item.total')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                <tr>
                   <td>{{$key+1}}</td>
                   <td>{{$product->barcode}}</td>
                   <td>{{$product->name}}</td>
                   <td>{{$product->qtd}}</td>
                   <td>{{number_format($product->price, 2)}}</td>
                   <td>{{number_format($product->total, 2)}}</td>

                </tr> 
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        @lang('messages.prompt.no_records')
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table> 
    </div>
</div>
