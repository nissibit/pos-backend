<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome do <?php  echo \Lang::get("messages.sidebar.". strtolower(class_basename($account->accountable))) ?></dt>
            <dd>{{ $account->accountable != NULL? $account->accountable->fullname : 'N/A' }}</dd>
            <dt>Dias para efectuar o pagamento</dt>
            <dd>{{ $account->days }}</dd>            
            <dt>Percentagem extra nos produtos</dt>
            <dd>{{ number_format($account->extra_price ?? 0, 2) }}</dd>            
            <dt>Credito</dt>
            <dd>{{ number_format($account->credit ?? 0, 2) }}</dd>            
            <dt>Debito</dt>
            <dd>{{ number_format($account->debit ?? 0, 2) }}</dd>                    
            <dt>Saldo</dt>
            <dd>{{ number_format($account->debit ?? 0, 2) }}</dd>           
             <dt>Desconto (%)</dt>
            <dd>{{ number_format($account->discount ?? 0, 2) }}</dd>            
        </dl>
        <form  action="{{ route('account.destroy',$account->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @can('account_edit')<a href="{{ route('account.edit', $account->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;@endcan
            @can('account_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-danger"><i class="fa fa-trash"> </i></button>@endcan
        </form>
    </div>
</div>