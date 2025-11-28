@extends("account.indexAccount")
@section("content-account")
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente/Fornecedor</th>
            <th>Nome</th>
            <th>Desconto</th>
            <th>Credit</th>
            <th>Debito</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($accounts as $key => $account)
        <tr>
            <td><a href="{{ route('account.show', $account->id) }}">{{ $account->id }}</a></td>
            <td>
                <?php
                $model = $account->accountable;
                $modelName = class_basename($model);
                $route = strtolower($modelName);
                echo \Lang::get("messages.sidebar.{$route}");
                $ac_id = $account->id ?? 0;
                ?>
            </td>
            <td><a href="{{ route('account.show', $ac_id) }}">{{  $model->fullname ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('account.show', $ac_id) }}">{{ number_format($account->discount ?? 0, 2) }}</a></td>                    
            <td class="text-right"><a href="{{ route('account.show', $ac_id) }}">{{ number_format($account->credit ?? 0, 2) }}</a></td>
            <td class="text-right"><a href="{{ route('account.show', $ac_id) }}">{{ number_format($account->debit ?? 0, 2) }}</a></td>
            <td class="text-right"><a href="{{ route('account.show', $ac_id) }}">{{ number_format($account->balance ?? 0, 2) }}</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center"> Sem registos ...</td>
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