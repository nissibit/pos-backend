@extends("partner.indexPartner")
@section("content-partner")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Empréstimo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($partners as $partner)
        <tr>
            <td><a href="{{ route('partner.show', $partner->id) }}"> {{ $partner->id }} </a></td>
            <td><a href="{{ route('partner.show', $partner->id) }}"> {{ $partner->type }} </a></td>
            <td><a href="{{ route('partner.show', $partner->id) }}"> {{ $partner->fullname }} </a></td>
            <td>{{ $partner->phone_nr }} </td>
            <td>{{ $partner->email }}</td>
            <td>
                <form action="{{ route('loan.create') }}" method="get" class="btn-group-sm" >
                    <input type="hidden" name="id" value="{{ $partner->id }}"  />
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                    <a href="{{ route('loan.by.partner', $partner->id) }}" class="btn btn-outline-success">
                        <i class="fas fa-list"></i>
                    </a>
                </form>
            </td>
        </tr> 
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
            <td class="text-center" colspan="6">  {{ $partners->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection