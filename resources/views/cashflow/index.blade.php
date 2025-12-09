@extends("cashflow.indexCashFlow")
@section("content-cashflow")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Motivo</th>
            <th>Data/Hora</th>
            @can('cashflow_destroy')<th>Apagar</th>@endcan
        </tr>
    </thead>
    <tbody>
        @forelse($cashflows as $cashflow)
        <tr>
            <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->type ?? 'N/A' }} </a></td>
            <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ number_format($cashflow->amount ?? 0, 2) ?? 'N/A' }} </a></td>
            <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->reason ?? 'N/A' }} </a></td>
            <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->created_at->format('d-m-Y / h:i:s') ?? 'N/A' }} </a></td>
            @can('cashflow_destroy')
            <td>
                <form  action="{{ route('cashflow.destroy',$cashflow->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>
                </form> 
            </td>
            @endcan
        </tr> 
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $cashflows->appends(request()->input())->links() }} </td>
        </tr>       
    </tfoot>
</table> 
@endsection