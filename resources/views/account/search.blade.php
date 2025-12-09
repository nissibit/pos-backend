@extends("account.indexAccount")
@section("content-account")
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
        $ac_id = $account->id ?? 0;
        ?>
        <tr>
            <td><a href="{{ route('account.show', $ac_id ) }}">{{ $ac_id ?? 'N/A' }}</a></td>
            <td><a href="{{ route('account.show', $ac_id) }}">{{ $account->customer->fullname ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('account.show', $ac_id) }}">{{ number_format($account->discount ?? 0, 2) }}</a></td>                    
            <td class="text-right">{{ number_format($account->credit ?? 0, 2) }}</td>
            <td class="text-right">{{ number_format($account->debit ?? 0, 2) }}</td>
            <td class="text-right">{{ number_format($account->balance ?? 0, 2) }}</td>

        </tr>      
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