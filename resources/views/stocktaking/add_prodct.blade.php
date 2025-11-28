@extends('stocktaking.indexStockTaking')
@section('content-stocktaking')
<div class="card">
    <div class="card-header">
        <i class="fas fa-calculator"> Iniciar um Inventário</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('stocktaking.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <input type="hidden" name="startime" id="startime" value="{{ \Carbon\Carbon::now() }}"  />
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Armazem/Loja <b class="text-danger">*</b></label>
                    <select class="form-control @error('store_id') is-invalid @enderror" name="store_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($stores ?? array() as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $dados['store_id'] ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                        @endforeach
                    </select>
                    @error('store_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>  
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-primary pull-right">
                        <i class="fa fa-check-circle"> iniciar</i>
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection
