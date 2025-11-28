<div class="alert alert-success">    
    <strong>@lang('messages.sale.total.visible'): {{ number_format($payments->sum('topay') ?? 0, 2) }} | #{{$payments->count()}}</strong>
</div>
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>#</th>
            <th>@lang('messages.cashflow.type')</th>
            <th>@lang('messages.prompt.id')</th>
            <th>@lang('messages.sale.customer_id')</th>
            <th>@lang('messages.sale.customer_phone')</th>
            <th>@lang('messages.sale.total')</th>
            <th>@lang('messages.prompt.date')</th>
            <th>@lang('messages.prompt.print')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $key => $payment)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{str_replace("App\\Models\\","", $payment->payment_type)}}</td>
            <td>{{$payment->nr ?? 'N/A'}}</td>
            <td>{{$payment->payment->customer_name ?? $payment->payment->account->accountable->fullname ?? 'N/A'}}</td>
            <td>{{$payment->payment->customer_phone ?? 'N/A'}}</td>
            <td>{{number_format($payment->topay, 2)}}</td>
            <td>{{$payment->created_at->format("d/m/Y h:i")}}</td>
            <td>
                @if($payment->payed)
                <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-danger ">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                <a href="{{ route('payment.copy', ['payment' => $payment->id]) }}" class="btn btn-outline-primary ">
                    <i class="fas fa-copy"> </i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>