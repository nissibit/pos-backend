@extends("creditnote.indexCreditNote")
@section("content-creditnote")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data</th>
            <th>Imprimir</th>
            <th>Copiar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($creditnotes as $key => $creditnote)
        <tr>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->id }}</a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->customer_name }}</a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->customer_phone }}</a></td>
            <td class="text-right"><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ number_format($creditnote->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->day->format('d-m-Y') }}</a></td>                                
            <td class="btn-group-sm">
                @if($creditnote->payed)
                <a href="{{ route('report.creditnote', $creditnote->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                {{ _('N/A') }}
                @endif
            </td>
             <td class="btn-group-sm">
                <a href="{{ route('creditnote.copy', ['id' => $creditnote->id]) }}" class="btn btn-primary">
                    <i class="fas fa-copy"> </i>
                </a>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="7" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" class="text-center"> 
                {{ $creditnotes->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection