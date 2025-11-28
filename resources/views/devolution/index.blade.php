@extends("devolution.indexDevolution")
@section("content-devolution")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Parceiro</th>
            <th>Contacto</th>
            <th>Produtos</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @forelse($devolutions as $key => $devolution)
       
        <tr>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->id }}</a></td>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->loan->partner->fullname }}</a></td>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->loan->partner->phone_nr }}</a></td>
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->items()->count() }}</a></td>            
            <td><a href="{{ route('devolution.show', $devolution->id) }}">{{ $devolution->created_at->format('d-m-Y') }}</a></td>            
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-center"> 
                {{ $devolutions->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection