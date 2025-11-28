<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <dd>{{ $payment->payment->customer_name ?? $payment->payment->accountable->fullname ?? 'N/A' }}</dd>
            <dt>Valor a pagar</dt>
            <dd>{{ number_format($payment->topay ?? 0, 2) }}</dd>            
            <dt>Valor pago</dt>
            <dd>{{ number_format($payment->payed ?? 0, 2) }}</dd>                    
            <dt>Troco</dt>
            <dd>{{ number_format($payment->change ?? 0, 2) }}</dd>           
            <dt>Data</dt>
            <dd>{{ $payment->day->format('d-m-Y h:i') ?? '' }}</dd>            
            <dt>Caixa</dt>
            <dd>{{ $payment->cashier->user->name ?? '' }}</dd>            
        </dl>
        <div class="row">
            <form  action="{{ route('payment.destroy',$payment->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}                    
                @if($payment->cashier->endtime == null)
                    @can('payment_destroy')
                     <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>
                    @endcan
                <?php if ((auth()->user()->hasAnyRoles("RH")) && ($payment->created_at->format('Y-m-d') == \Carbon\Carbon::now()->format('Y-m-d'))) : ?>
                     <button  type="submit" data-toggle="confirmation" data-title="Suprimir Pagamento?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>
                <?php endif; ?>
                @endif
            </form>
            &nbsp;&nbsp;
            @can('audit_payment')
            <form role='form' action="{{ route('audit.entity') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $payment->id }}"  />
                <input type="hidden" name="model" value="\App\Models\Payment"  />
                <input type="hidden" name="name" value="{{ $payment->created_at->format('d-m-Y h:i') }}"  />
                <button type="submit" class="btn btn-primary">            
                    <i class="fa fa-user-shield"> auditar</i>
                </button>
            </form>
            &nbsp;
            <a href="{{ route('creditnote.create', ['id' => $payment->id]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-plus"> Nota de credito</i>
            </a>
            @endcan

        </div>
    </div>
</div>