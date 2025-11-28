@extends("customer.indexCustomer")
@section("content-customer")
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @forelse($customers as $customer)
        <tr>
            <td><a href="{{ route('customer.show', $customer->id) }}"> {{ $customer->id }} </a></td>
            <td><a href="{{ route('customer.show', $customer->id) }}"> {{ $customer->type }} </a></td>
            <td><a href="{{ route('customer.show', $customer->id) }}"> {{ $customer->fullname }} </a></td>
            <td>{{ $customer->phone_nr }} </td>
            <td>{{ $customer->email }}</td>
        </tr> 
        @empty
        <tr>
            <td colspan="5" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $customers->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection