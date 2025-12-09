@php
$outputs = $customer->outputs()->latest()->paginate(10);
@endphp
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data</th>
            <th>Operações</th>
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
            <td class="text-center">                                  
                <form  action="{{ route('output.destroy',$output->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}                  
                    <a href="{{ route('report.output.modelo_1', $output->id) }}" class="btn btn-outline-danger">
                        <i class="fas fa-print"> </i>
                    </a>
                    @can('output_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>@endcan                    
                </form>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $outputs->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 