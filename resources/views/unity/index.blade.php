@extends("unity.indexUnity")
@section("content-unity")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>Abreviatura</th>
            <th>Descricao</th>
        </tr>
    </thead>
    <tbody>
        @forelse($unities as $unity)
        <tr>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->id }} </a></td>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->name }} </a></td>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->label }} </a></td>
            <td>{{ $unity->description }}</td>
        </tr> 
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
</table> 
@endsection