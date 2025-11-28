@extends("admin.profissao.indexProfissao")
@section("content-profissao")
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Profissão </i>                   
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('profissao.update', $profissao->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}    
            <div class="row">
                <div class="form-group input-group-sm col-sm-6">
                    <label for="name">Nome/Designação <b class="text-danger">*</b></label>                   
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $profissao->name ?? '') }}" >
                    @error('name')
                    <span class="invalid-feedback" profissão ="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group  input-group-sm col-sm-6">
                    <label for="alias">Sigla <b class="text-danger">*</b></label>                       
                    <input id="alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias', $profissao->alias ?? '') }}" >
                    @error('alias')
                    <span class="invalid-feedback" profissão ="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group input-group-sm col-sm-6">
                    <label for="description">Descrição<b class="text-danger">*</b></label>                       
                    <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $profissao->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" profissão ="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col text-right btn-group-sm">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fa fa-edit"> editar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
