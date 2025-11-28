@extends("quotation.indexQuotation")
@section("content-quotation")
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data</th>
            <th>M-A4</th>
            <th>M-A5</th>
            <th>Copiar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($quotations as $key => $quotation)
        <tr>
            <td><a href="{{ route('quotation.show', $quotation->id) }}">{{ $quotation->id }}</a></td>
            <td><a href="{{ route('quotation.show', $quotation->id) }}">{{ $quotation->customer_name }}</a></td>
            <td><a href="{{ route('quotation.show', $quotation->id) }}">{{ $quotation->customer_phone }}</a></td>
            <td class="text-right"><a href="{{ route('quotation.show', $quotation->id) }}">{{ number_format($quotation->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('quotation.show', $quotation->id) }}">{{ $quotation->day->format('d-m-Y') }}</a></td>                                
            <td>
                <a href="{{ route('report.quotation', $quotation->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> </i>
                </a>
            </td>
            <td>
                <a href="{{ route('report.quotation.modelo2', $quotation->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> </i>
                </a>
            </td>
            <td>
                <a href="{{ route('quotation.copy', ['id' => $quotation->id]) }}" class="btn btn-primary">
                    <i class="fas fa-copy"> </i>
                </a>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="8" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8" class="text-center"> 
                {{ $quotations->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table> 
@endsection