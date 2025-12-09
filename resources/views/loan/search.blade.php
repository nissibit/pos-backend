@extends("loan.indexLoan")
@section("content-loan")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            @can('show_total_loan')<th>Total</th>@endcan
            <th>Data</th>
            @can('show_total_loan')<th>Imprimir</th>
            <th>Copiar</th>@endcan
        </tr>
    </thead>
    <tbody>
        @forelse($loans as $key => $loan)
        <tr>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->id }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->customer_name }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->customer_phone }}</a></td>
            @can('show_total_loan')<td class="text-right"><a href="{{ route('loan.show', $loan->id) }}">{{ number_format($loan->total ?? 0, 2) }}</a></td>@endcan
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->day->format('d-m-Y') }}</a></td>        @can('show_total_loan')                               
            <td class="btn-group-sm">
                @if($loan->payed)
                <a href="{{ route('report.loan', $loan->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                'N/A'
                @endif
            </td>
             <td class="btn-group-sm">
                <a href="{{ route('loan.copy', ['id' => $loan->id]) }}" class="btn btn-primary">
                    <i class="fas fa-copy"> </i>
                </a>
            </td>
            @endcan
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
                {{ $loans->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection