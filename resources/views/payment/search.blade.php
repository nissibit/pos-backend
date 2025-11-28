@extends("payment.indexPayment")
@section("content-payment")
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Nr pag.</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data</th>
            <th>Pagar</th>
        </tr>
    </thead>
    <tbody>

        @forelse($payments as $key => $payment)
        <?php
        $model = $payment->payment;
        $modelName = class_basename($model);
        $route = strtolower($modelName);
//        echo \Lang::get("messages.sidebar.{$route}")
        ?>
        @if($payment->payment != null)
        <tr>
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $modelName }}</a></td>
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->nr }}</a></td>
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->customer_name ?? $payment->payment->account->accountable->fullname ?? 'N/A' }}</a></td>
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->customer_phone ?? $payment->payment->account->accountable->phone_nr ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('payment.show', $payment->id) }}">{{ number_format($payment->payment->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->created_at->format('d-m-Y h:i') ?? 'N/A' }}</a></td>                                
            <td>
                <div class="btn-group-sm text-center">

                    @if($payment->payed)
                    <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-danger ">
                        <i class="fas fa-print"> </i>
                    </a>
                    @else
                    <a href="{{ route('payment.copy', ['payment' => $payment->id]) }}" class="btn btn-outline-primary ">
                        <i class="fas fa-copy"> </i>
                    </a>
                    @endif
                </div>
            </td>
        </tr>
        @endif
        @empty
        <tr>
            <td colspan="7" class="text-center"> Sem pagamentos de Créditos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $payments->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection