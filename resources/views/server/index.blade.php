@extends("server.indexServer")
@section("content-server")

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
        @forelse($servers as $server)
        <tr>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->id }} </a></td>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->type }} </a></td>
            <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->fullname }} </a></td>
            <td>{{ $server->phone_nr }} </td>
            <td>{{ $server->email }}</td>
        </tr> 
        @empty
        <tr>
            <td colspan="5" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
</table> 
@endsection