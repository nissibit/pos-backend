@extends("moneyflow.indexMoneyFlow")
@section("content-moneyflow")
<div class="alert alert-info">
    {{ "Pesquisando por: " }}<strong>{{ $dados['criterio'] }}</strong>
</div>

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>Valor</th>
            <th>Motivo</th>
            <th>Data / Hora</th>
            @can('moneyflow_destroy')<th>Apagar</th>@endcan
        </tr>
    </thead>
    <tbody>
        @forelse($moneyflows as $moneyflow)
        <tr>
            <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ number_format($moneyflow->amount ?? 0, 2) ?? 'N/A' }} </a></td>
            <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ $moneyflow->reason ?? 'N/A' }} </a></td>
            <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ $moneyflow->created_at->format('d-m-Y / h:i:s') ?? 'N/A' }} </a></td>
            @can('moneyflow_destroy')
            <td>
                <form  action="{{ route('moneyflow.destroy',$moneyflow->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>
                </form> 
            </td>
            @endcan
        </tr> 
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="4">  {{ $moneyflows->appends(request()->input())->links() }} </td>
        </tr>       
    </tfoot>
</table> 
@endsection