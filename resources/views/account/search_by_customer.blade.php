@extends("account.indexAccount")
@section("content-account")
@php
$accounts = \App\Models\Account::latest()->paginate(10);
@endphp
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Desconto</th>
            <th>Credit</th>
            <th>Debito</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($accounts as $key => $account)
         <?php
        $model = $account->accountable;
        $modelName = class_basename($model);
        $route = strtolower($modelName);
        $type =  \Lang::get("messages.sidebar.{$route}");
        $server =  \Lang::get("messages.sidebar.customer");        
        ?>
        @if($type == $server)
        <tr>
            <td><a href="{{ route('account.show', $account->id) }}">{{ $account->id }}</a></td>
            <td><a href="{{ route('account.show', $account->id) }}">{{ $account->customer->fullname }}</a></td>
            <td class="text-right"><a href="{{ route('account.show', $account->id) }}">{{ number_format($account->discount ?? 0, 2) }}</a></td>                    
            <td class="text-right">{{ number_format($account->credit ?? 0, 2) }}</td>
            <td class="text-right">{{ number_format($account->debit ?? 0, 2) }}</td>
            <td class="text-right">{{ number_format($account->balance ?? 0, 2) }}</td>            
        </tr>
        @endif
        @empty
        <tr>
            <td class="text-center" colspan="6"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $accounts->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection