@extends("output.indexOutput")
@section("content-output")

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
        @forelse($outputs as $key => $output)
        <tr>
            <td><a href="{{ route('output.show', $output->id) }}">{{ $output->id }}</a></td>
            <td><a href="{{ route('output.show', $output->id) }}">{{ $output->customer_name }}</a></td>
            <td><a href="{{ route('output.show', $output->id) }}">{{ $output->customer_phone }}</a></td>
            <td class="text-right"><a href="{{ route('output.show', $output->id) }}">{{ number_format($output->total ?? 0, 2) }}</a></td>
            <td><a href="{{ route('output.show', $output->id) }}">{{ $output->day->format('d-m-Y') }}</a></td>                                
            <td>
                <a href="{{ route('report.output.modelo_1', $output->id) }}" class="btn btn-danger">
                    <i class="fas fa-print"> M-A4 </i>
                </a>
                &nbsp;
                <a href="{{ route('report.output.modelo_2', $output->id) }}" class="btn btn-danger">
                    <i class="fas fa-print"> M-A5 </i>
                </a>
            </td>
            <td>
                <a href="{{ route('output.copy', ['id' => $output->id]) }}" class="btn btn-primary">
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
                {{ $outputs->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection