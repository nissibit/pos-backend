<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Produto</th>
            <th>Stock</th>
            <th>Vendido</th>
            <th>Factura</th>
            <th>Utilizador</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @forelse($runoutsells as $runoutsell)
        @php 
        $product = $runoutsell->product;
        @endphp
        <tr>
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->id }} </a></td>
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->name }} </a></td>
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->quantity_available }} </a></td>
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->quantity }} </a></td>           
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->factura->id ?? 'N/A'}} </a></td>           
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->audits()->latest()->first()->user->name }} </a></td>           
            <td><a href="{{ route('runoutsell.show', $runoutsell->id) }}"> {{ $runoutsell->created_at->format('d-m-Y h:i') }} </a></td>           
        </tr> 
        @empty
        <tr>
            <td colspan="7" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $runoutsells->appends(request()->input())->links() }} </td>
        </tr>
    </tfoot>
</table> 