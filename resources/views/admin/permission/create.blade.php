@extends("admin.permission.indexPermission")
@section("content-permission")
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus-circle"> Registar Permissao</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('permission.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group input-group-sm col-sm-6">
                    <label for="name">Nome/Designação <b class="text-danger">*</b></label>                   
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $permission->name ?? '') }}" >
                    @error('name')
                    <span class="invalid-feedback" permission="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group  input-group-sm col-sm-6">
                    <label for="label">Sigla <b class="text-danger">*</b></label>                       
                    <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $permission->label ?? '') }}" >
                    @error('label')
                    <span class="invalid-feedback" permission="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group input-group-sm col-sm-6">
                    <label for="description">Descrição<b class="text-danger">*</b></label>                       
                    <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $permission->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" permission="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col text-right btn-group-sm">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-check-circle"> criar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
