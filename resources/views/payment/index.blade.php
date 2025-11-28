@extends("payment.indexPayment")
@section("content-payment")
@if($open ?? '' == 0)
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Nr fact/pag.</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data</th>
            <th>Pagar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($facturas as $key => $factura)
        <tr>
            <td><a href="{{ route('factura.show', $factura->id) }}">Factura</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->id }}</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->customer_name }}</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->customer_phone }}</a></td>
            <td class="text-right"><a href="{{ route('factura.show', $factura->id) }}">{{ number_format($factura->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->created_at->format('d-m-Y h:i') }}</a></td>                                
            <td>
                <div class="btn-group-sm text-center">

                    @if($factura->payed)
                    <a href="{{ route('payment.show', $factura->payments()->first() != null ? $factura->payments()->first()->id : 1) }}" class="btn btn-danger ">
                        <i class="fas fa-print"> </i>
                    </a>
                    @else
                    <a href="{{ route('payment.create', ['factura' => $factura->id]) }}" class="btn btn-outline-primary ">
                        <i class="fas fa-arrow-right"> </i>
                    </a>
                    
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center bg-primary text-light text-uppercase"> Sem factura para pagar ...</td>
        </tr>
        @endforelse
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
            <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->nr ?? 'N/A' }}</a></td>
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
            <td colspan="6" class="text-center"> 
                {{ $payments->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endif
@endsection