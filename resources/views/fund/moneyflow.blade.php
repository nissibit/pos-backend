<div class="col">
    @php
    $moneyflows = $fund->moneyflows()->latest()->paginate(10);
    $entradas = $fund->moneyflows()->where('type', 'Entrada')->sum('amount');
    $saidas = $fund->moneyflows()->where('type', 'Saida')->sum('amount');
    @endphp
    <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
        <thead>
            <tr class="bg-light">
                <th colspan="2" >Entradas: {{ number_format($entradas, 2) }}</th>
                <th>&nbsp;</th>
                <th colspan="2">Saidas: {{ number_format($saidas, 2) }}</th>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Motivo</th>
                <th>Hora</th>
               <th>Apagar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($moneyflows ?? array() as $moneyflow)
            <tr>
                <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ $moneyflow->type ?? 'N/A' }} </a></td>
                <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ number_format($moneyflow->amount ?? 0, 2) ?? 'N/A' }} </a></td>
                <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ $moneyflow->reason ?? 'N/A' }} </a></td>
                <td><a href="{{ route('moneyflow.show', $moneyflow->id) }}"> {{ $moneyflow->created_at->format('h:i:s') ?? 'N/A' }} </a></td>
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
                <td colspan="6" class="text-center">
                    Sem registos ...
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center" colspan="7">  {{ $moneyflows->appends(request()->input())->links() }} </td>
            </tr>       
        </tfoot>
    </table> 
</div>