@extends("fund.indexFund")
@section("content-fund")
<table class="table table-bordered table-sm table-responsive-sm" id="todosFunds">
    <thead>
        <tr>
            <th>Data</th>
            <th>Utilizador</th>
            <th>Valor Disponível</th>
            <th>Saídas</th>
        </tr>
    </thead>
    <tbody> 
        @forelse($funds as $fund)
        <tr>
            <td><a href="{{ route('fund.show', $fund->id) }}"> {{ $fund->startime->format('d-m-Y') }}</a></td>
            <td><a href="{{ route('fund.show', $fund->id) }}"> {{ $fund->user->name }}</a></td>
            <td><a href="{{ route('fund.show', $fund->id) }}"> {{ number_format($fund->present, 2) }}</a></td>            
            <td  class="text-center btn-group-sm">
                <a href="{{ route('report.fund.moneyflow', ['id' => $fund->id]) }}" class="btn btn-danger">
                    <i class="fa fa-print"> </i>
                </a>    
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
