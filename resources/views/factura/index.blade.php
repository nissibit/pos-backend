@extends("factura.indexFactura")
@section("content-factura")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            @can('show_total_factura')<th>Total</th>@endcan
            <th>Data</th>
            @can('show_total_factura')<th>Imprimir</th>
            <th>Copiar</th>@endcan
        </tr>
    </thead>
    <tbody>
        @forelse($facturas as $key => $factura)
        <tr>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->id }}</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->customer_name }}</a></td>
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->customer_phone }}</a></td>
            @can('show_total_factura')<td class="text-right"><a href="{{ route('factura.show', $factura->id) }}">{{ number_format($factura->total ?? 0, 2) }}</a></td>@endcan
            <td><a href="{{ route('factura.show', $factura->id) }}">{{ $factura->day->format('d-m-Y') }}</a></td>        @can('show_total_factura')                               
            <td class="btn-group-sm">
                @if($factura->payed)

                <a href="{{ route('payment.print_simple', $factura->payments()->first() != null ? $factura->payments()->first()->id : 1) }}" class="btn btn-danger ">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                {{ __('N/A') }}
                @endif
            </td>
             <td class="btn-group-sm">
                <a href="{{ route('factura.copy', ['id' => $factura->id]) }}" class="btn btn-primary">
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
                {{ $facturas->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection