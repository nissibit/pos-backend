@extends('unity.indexUnity')
@section('content-unity')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-plus-circle"> Registar Empresa</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('unity.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $unity->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Abreviatura <b class="text-danger">*</b></label>
                    <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $unity->label ?? '') }}"  >
                    @error('label')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $unity->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-primary pull-right">
                        <i class="fa fa-check-circle"> criar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
