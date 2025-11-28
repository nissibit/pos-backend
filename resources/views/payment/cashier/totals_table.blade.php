<div class="row">
    <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
        <thead>
            <tr>
                <th>@lang('messages.payment.way')</th>
                <th>@lang('messages.cashier.present')</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPresent = 0;
            @endphp

            @foreach($totals as $total)
            @php $totalPresent += $total->present; @endphp
            <tr>
                <td>{{ $total->way }}</td>
                <td class="text-right">{{ number_format($total->present, 2) }}</td>
            </tr>
            @endforeach
        </tbody>       
        <tfoot>
            <tr>
                <th>@lang('messages.item.total')</th>
                <th class="text-right">{{ number_format($totalPresent, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>