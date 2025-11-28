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
            <td class="text-center" colspan="7">  {{ $partners->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection