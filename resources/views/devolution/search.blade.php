@extends("devolution.indexDevolution")
@section("content-devolution")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            @can('show_total_devolution')<th>Total</th>@endcan
            <th>Data</th>
            @can('show_total_devolution')<th>Imprimir</th>
            <th>Copiar</th>@endcan
        </tr>
    </thead>
    <tbody>
        @forelse($devolutions as $key => $devolution)
        <tr>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->id }}</a></td>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->customer_name }}</a></td>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->customer_phone }}</a></td>
            @can('show_total_devolution')<td class="text-right"><a href="{{ route('devolution.show', $devolution->id) }}">{{ number_format($devolution->total ?? 0, 2) }}</a></td>@endcan
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->day->format('d-m-Y') }}</a></td>        @can('show_total_devolution')                               
            <td class="btn-group-sm">
                @if($devolution->payed)
                <a href="{{ route('report.devolution', $devolution->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                {{ _('N/A') }}
                @endif
            </td>
             <td class="btn-group-sm">
                <a href="{{ route('devolution.copy', ['id' => $devolution->id]) }}" class="btn btn-primary">
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
                {{ $devolutions->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection