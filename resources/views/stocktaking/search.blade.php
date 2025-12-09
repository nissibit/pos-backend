@extends("stocktaking.indexStockTaking")
@section("content-stocktaking")
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Armazem</th>
            <th>Inicio</th>
            <th>Termino</th>
            <th>Produtos(#)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stocktakings as $stocktaking)
        <tr>
            <td><a href="{{ route('stocktaking.show', $stocktaking->id) }}"> {{ $stocktaking->id }} </a></td>
            <td><a href="{{ route('stocktaking.show', $stocktaking->id) }}"> {{ $stocktaking->store->name }} </a></td>
            <td><a href="{{ route('stocktaking.show', $stocktaking->id) }}"> {{ $stocktaking->startime->format('d-m-Y h:i') }} </a></td>
            <td><a href="{{ route('stocktaking.show', $stocktaking->id) }}"> {{ $stocktaking->endtime != null ? $stocktaking->endtime->format('d-m-Y h:i') : 'N/A' }} </a></td>
            <td class="text-right"><a href="{{ route('stocktaking.show', $stocktaking->id) }}"> {{ $stocktaking->products != null ? $stocktaking->products-->count() : '0' }} </a></td>
        </tr> 
        @empty
        <tr>
            <td colspan="5" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <thead>
         <tr>
            <td colspan="5" class="text-center">
               {{ $stocktakings->links() }}
            </td>
        </tr>
    </thead>
</table> 
@endsection