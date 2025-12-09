<div class="col">
    @php
    $cashflows = $cashier->cashflows()->latest()->paginate(10);
    $entradas = $cashier->cashflows()->where('type', 'Entrada')->sum('amount');
    $saidas = $cashier->cashflows()->where('type', 'Saida')->sum('amount');
    @endphp
    <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
        <thead>
            <tr class="bg-light">
                <th colspan="2" >@lang('messages.cashier.inputs'): {{ number_format($entradas, 2) }}</th>
                <th>&nbsp;</th>
                <th colspan="2">@lang('messages.cashier.outputs'): {{ number_format($saidas, 2) }}</th>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <th>@lang('messages.cashflow.type')</th>
                <th>@lang('messages.cashflow.amount')</th>
                <th>@lang('messages.cashflow.reason')</th>
                <th>@lang('messages.prompt.hour')</th>
               <th>@lang('messages.item.delete')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashflows ?? array() as $cashflow)
            <tr>
                <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->type ?? 'N/A' }} </a></td>
                <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ number_format($cashflow->amount ?? 0, 2) ?? 'N/A' }} </a></td>
                <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->reason ?? 'N/A' }} </a></td>
                <td><a href="{{ route('cashflow.show', $cashflow->id) }}"> {{ $cashflow->created_at->format('h:i:s') ?? 'N/A' }} </a></td>
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
                    @lang('messages.prompt.no_records')
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center" colspan="7">  {{ $cashflows->appends(request()->input())->appends('tab', '2')->links() }} </td>
            </tr>       
        </tfoot>
    </table> 
</div>