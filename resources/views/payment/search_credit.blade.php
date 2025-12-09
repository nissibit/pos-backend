@extends('payment.indexPayment')
@section('content-payment')
    <table class="table table-bordered table-hover table-responsive-sm table-sm">
        <thead>
            <tr>
                <td colspan="7">
                    <div class="form-group col input-group-sm">
                        <form id="payment_search" role="form" autocomplete="off"
                            action="{{ route('payment.credit.search') }}" method="get" class="m-sm-1">
                            <div class="input-group-sm input-group">
                                <input type="text" name="criterio" class="form-control"
                                    placeholder="Procurar pagamento de créditos"
                                    value="{{ old('criterio', $dados['criterio'] ?? '') }}">
                                <span class="input-group-btn btn-group-sm ">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Tipo</th>
                <th>Nr pag.</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Total</th>
                <th>Data da Conceção</th>
                <th>Data de Pag.</th>
                <th>Imprimir</th>
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
                <tr>
                    <td><a href="{{ route('payment.show', $payment->id) }}">{{ $modelName }}</a></td>
                    <td><a href="{{ route('payment.show', $payment->id) }}">{{ $payment->nr }}</a></td>
                    <td><a
                            href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->customer_name ?? ($payment->payment->account->accountable->fullname ?? 'N/A') }}</a>
                    </td>
                    <td><a
                            href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->customer_phone ?? ($payment->payment->account->accountable->phone_nr ?? 'N/A') }}</a>
                    </td>
                    <td class="text-right"><a
                            href="{{ route('payment.show', $payment->id) }}">{{ number_format($payment->payment->total ?? 0, 2) }}</a>
                    </td>
                    <td><a
                            href="{{ route('payment.show', $payment->id) }}">{{ $payment->created_at->format('d-m-Y h:i') ?? 'N/A' }}</a>
                    </td>
                    <td><a
                            href="{{ route('payment.show', $payment->id) }}">{{ $payment->payment->created_at->format('d-m-Y h:i') ?? 'N/A' }}</a>
                    </td>
                    <td>
                        <div class="btn-group-sm text-center">

                            @if ($payment->payed)
                                <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-danger ">
                                    <i class="fas fa-print"> </i>
                                </a>
                            @else
                                <a href="{{ route('payment.copy', ['payment' => $payment->id]) }}"
                                    class="btn btn-outline-primary ">
                                    <i class="fas fa-copy"> </i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center"> Sem pagamentos de Créditos ...</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center" colspan="7"> {{ $payments->appends(request()->input())->links() }} </td>
            </tr>

        </tfoot>
    </table>
@endsection
