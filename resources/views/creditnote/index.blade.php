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
        </tr>
    </thead>
    <tbody>
        @forelse($creditnotes as $key => $creditnote)
        <tr>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->id }}</a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->payment->payment->acccountable->fullname ?? $creditnote->payment->payment->customer_name ?? 'N/A' }} </a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->payment->payment->acccountable->address ?? $creditnote->payment->payment->customer_address ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ number_format($creditnote->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('creditnote.show', $creditnote->id) }}">{{ $creditnote->created_at->format('d-m-Y / h:i') }}</a></td>                                
            <td class="btn-group-sm">
                <a href="{{ route('report.creditnote', ['id'=>$creditnote->id, 'm' => 'a4']) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> M-A4</i>
                </a> &nbsp;
                <a href="{{ route('report.creditnote', ['id'=>$creditnote->id, 'm' => 'a5']) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> M-A5</i>
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