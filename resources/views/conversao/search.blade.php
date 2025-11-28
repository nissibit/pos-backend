@extends("conversao.indexConversao")
@section("content-conversao")
<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>#</th>
            <th>Produto Origem</th>
            <th>Quantidade</th>
            <th>Retalho</th>
            <th>Produto Destino</th>
            <th>Total Recebido</th>
        </tr>
    </thead>
    <tbody>
        @forelse($conversaos as $key => $conversao)
        <tr>  
            <td ><a href="{{ route('conversao.show', $conversao->id) }}">{{ $conversao->id ?? 'N/A' }}</a></td>
            <td><a href="{{ route('conversao.show', $conversao->id) }}">{{ $conversao->stock_from->product->name ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('conversao.show', $conversao->id) }}">{{ number_format($conversao->quantity ?? 0, 2) }}</a></td>                    
            <td class="text-right"><a href="{{ route('conversao.show', $conversao->id) }}">{{ number_format($conversao->flap ?? 0, 2) }}</a></td>
            <td ><a href="{{ route('conversao.show', $conversao->id) }}">{{ $conversao->stock_to->product->name ?? 'N/A' }}</a></td>
            <td class="text-right"><a href="{{ route('conversao.show', $conversao->id) }}">{{ number_format($conversao->total ?? 0, 2) }}</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center"> {{ $conversaos->appends(request()->input())->links() }}</td>
        </tr>
    </tfoot>
</table>
@endsection