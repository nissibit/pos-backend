<div class="card">
    <?php
    $total = $factura->items()->count();
    $items = $factura->items()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ __('messages.item.total')." : ".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>@lang('messages.prompt.item')</th>
                    <th>@lang('messages.sale.product')</th>
                    <th>@lang('messages.item.quantity').</th>
                    <th>@lang('messages.item.unitprice')</th>
                    <th>@lang('messages.sale.totalrate') (%)</th>
                    <th>@lang('messages.item.total')</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal  = $factura->items()->sum('subtotal') / 1.16; ?>
                @forelse($items as $key => $item)
                <tr>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->barcode }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></td>
                    <td><a href="{{ route('product.show', $item->product->id) }}">{{ $item->quantity }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->unitprice ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->rate ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('product.show', $item->product->id) }}">{{ number_format($item->unitprice*$item->quantity ?? 0, 2) }}</a></td>                    
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" class="text-center">@lang('messages.prompt.no_records')</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">@lang('messages.sale.total')</th>
                    <th class="text-right">{{ number_format($subtotal*1.16,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $items->appends(request()->input())->links() }}
    </div>
</div>
