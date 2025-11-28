<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do Cliente</dt>
            <?php
            $model = $credit->account->accountable;
            $modelName = class_basename($model);
            $route = strtolower($modelName).".show";
            ?>
            <dd><a href="{{ route($route, $credit->account->accountable->id) }}">{{ $credit->account->accountable->fullname }}</a></dd>       
            <dt>Data </dt>
            <dd>{{ $credit->day->format('d-m-Y / h:i') }}</dd> 
            <dt>Subtotal</dt>
            <dd>{{ number_format($credit->total ?? 0, 2) }}</dd>            
            <dt>Desconto</dt>
            <dd>{{ number_format($credit->debit ?? 0, 2) }}</dd>                    
            <dt>Total</dt>
            <dd>{{ number_format($credit->total ?? 0, 2) }}</dd>               
        </dl>
        <form  action="{{ route('credit.destroy',$credit->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
           
            <a href="{{ route('report.credit', $credit->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> m-a4</i>
            </a>
            <a href="{{ route('report.credit.modelo_a5', $credit->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> m-a5</i>
            </a>
            @if(!$credit->payed)
            @can('credit_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
            @endif
        </form>

    </div>
</div>