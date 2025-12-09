@extends("unity.indexUnity")
@section("content-unity")
<table  class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>Abreviatura</th>
            <th>Descricao</th>
        </tr>
    </thead>
    <tbody>
        @foreach($unities as $unity)
        <tr>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->id }} </a></td>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->name }} </a></td>
            <td><a href="{{ route('unity.show', $unity->id) }}"> {{ $unity->label }} </a></td>
            <td>{{ $unity->description }}</td>
           
        </tr>                            
        @endforeach
    </tbody>
</table> 
@endsection