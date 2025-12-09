@extends('invoice.indexInvoice')
@section('content-invoice')
<div class="card">
    <div class="card-header">
        <h2><i class="fa fa-check-circle"></i> Seleccionar fornecedor</h2>
    </div>
    <div class="card-body">
        <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servers as $server)
                <tr>
                    <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->id }} </a></td>
                    <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->type }} </a></td>
                    <td><a href="{{ route('server.show', $server->id) }}"> {{ $server->fullname }} </a></td>
                    <td>{{ $server->phone_nr }} </td>
                    <td class="text-center">
                        <form  id="unity_search" role="form" autocomplete="off" action="{{ route('invoice.create') }}" method="get" class="form-inline">

                            <div class="input-group-sm input-group">
                                <select class="form-control @error('store_id') is-invalid @enderror" name="store_id">
                                    @foreach($stores ?? array() as $store)
                                    <option value="{{ $store->id }}" {{ old('store_id', $dados['store_id'] ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                                    @endforeach
                                </select>
                                @error('store_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <input type="hidden" name="server_id" class="form-control"  value="{{ old('server_id', $server->id ?? '') }}" />
                                <span class="input-group-btn btn-group-sm ">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-check-circle"> </i>
                                    </button>
                                </span>
                            </div>                                  
                        </form>
                    </td>
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
    </div>
    <div class="card-footer">
        {{ $servers->appends(request()->input())->links() }}
    </div>
</div>
@endsection