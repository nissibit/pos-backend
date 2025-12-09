@extends("store.indexStore")
@section("content-store")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>Abreviatura</th>
            <th>Descricao</th>
            <th>Transf.</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $store)
        <tr>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->id }} </a></td>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->name }} </a></td>
            <td><a href="{{ route('store.show', $store->id) }}"> {{ $store->label }} </a></td>
            <td>{{ $store->description }}</td>
            <td class="text-center">
                <form id="store_search" role="form" autocomplete="off" action="{{ route('store.search') }}" method="get" class="m-sm-1">
                    <div class="input-group-sm input-group text-center">
                        <input type="hidden" name="store_id" class="form-control" value="{{ old('store_id', $store->id ?? '') }}" >
                        <span class="input-group-btn btn-group-sm ">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-exchange-alt"> </i>
                            </button>
                        </span>
                    </div>                                  
                </form>
            </td>
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