@extends("loan.indexLoan")
@section("content-loan")

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Parceiro</th>
            <th>Contacto</th>
            <th>Produtos</th>
            <th>Data Concepção</th>
            <th>Previsão Devolução</th>
            <th>Estado</th>
            <th>Devoluções</th>
        </tr>
    </thead>
    <tbody>
        @forelse($loans as $key => $loan)
        <tr>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->id }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->partner->fullname }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->partner->phone_nr }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->articles()->count() }}</a></td>            
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->created_at->format('d-m-Y') }}</a></td>            
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->returned_date->format('d-m-Y') }}</a></td>            
            <td class="btn-group-sm">
                @if($loan->status == "PAGO")
                <i class="fas fa-check-circle text-success"> PAGO</i>                
                @else
                <form method="get" action="{{ route('devolution.create') }}">
                    <input type="hidden" name="id" value="{{ $loan->id }}" />
                    <button type="submit" class="btn btn-outline-primary btn-group-sm" title="Pagar">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                @endif
            </td>  
            <td class="btn-group-sm">
                @if($loan->devolutions()->count()> 0)
                <a href="{{ route('devolutions.by.loan', $loan->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-list"> devoluções</i>
                </a>
                @endif
            </td>
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
                {{ $loans->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection