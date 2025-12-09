@extends("store.indexStore")
@section("content-store")
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
        @foreach($categories as $store)
        <tr>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->id }} </a></td>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->name }} </a></td>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->label }} </a></td>
            <td>{{ $store->description }}</td>            
        </tr>                            
        @endforeach
    </tbody>
</table> 
@endsection