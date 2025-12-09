@extends("transference.indexTransference")
@section("content-transference")
<table  class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
            <th>Item</th>
            <th>Produtos</th>
            <th>Origem</th>
            <th>Destino</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
          <?php $i = 1; ?>
        @forelse($transferences as $transference)
        <tr>
            <td><a href="{{ route('transference.show', $transference->id) }}"> {{ $i }} </a></td>
            <td><a href="{{ route('transference.show', $transference->id) }}"> {{ $transference->items()->count() }} </a></td>
            <td><a href="{{ route('transference.show', $transference->id) }}"> {{ $transference->store_from->name ?? 'N/A' }} </a></td>            
            <td><a href="{{ route('transference.show', $transference->id) }}"> {{ $transference->store_to->name ?? 'N/A' }} </a></td>            
            <td><a href="{{ route('transference.show', $transference->id) }}"> {{ $transference->day->format('d-m-Y') ?? 'N/A' }} </a></td>            
            
        </tr>  
          <?php $i++; ?>
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center">
                {{ $transferences->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table> 
@endsection