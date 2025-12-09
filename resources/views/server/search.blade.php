@extends("server.indexServer")
@section("content-server")
<table  class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @forelse($servers as $server)
        <tr>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->id }} </a></td>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->type }} </a></td>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->fullname }} </a></td>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->phone_nr }} </a></td>
            <td>{{ $server->email }}</td>           
        </tr>      
        @empty
        <tr>
            <td class="text-center" colspan="6"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $servers->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table> 
@endsection