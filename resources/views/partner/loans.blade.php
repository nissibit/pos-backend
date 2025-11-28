@extends('partner.indexPartner')
@section('content-partner')
<div class="alert alert-info">
    <h3>Empréstimos do parceiro</h3>
</div>
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
        @forelse($loans as $key => $loan)
        <tr>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->id }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->partner->fullname }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->partner->phone_nr }}</a></td>
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->articles()->count() }}</a></td>            
            <td><a href="{{ route('loan.show', $loan->id) }}">{{ $loan->created_at->format('d-m-Y') }}</a></td>            
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center"> 
                {{ $loans->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection