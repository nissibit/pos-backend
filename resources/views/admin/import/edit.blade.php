@extends('admin.import.indexImport')
@section('content-import')
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Empresa <b>{{$import->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('import.update', $import->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $import->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="tel" class="control-label">Telefone <b class="text-danger">*</b></label>
                    <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel', $import->tel ?? '') }}"  >
                    @error('tel')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="nuit" class="control-label">NUIT <b class="text-danger">*</b></label>
                    <input id="nuit" type="text" class="form-control @error('nuit') is-invalid @enderror" name="nuit" value="{{ old('nuit', $import->nuit ?? '') }}"  >
                    @error('nuit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='fax' class="control-label">Fax </label>
                    <input id='fax' type="text" class="form-control @error('fax') is-invalid @enderror" name='fax' value="{{ old('fax', $import->fax ?? '') }}"  >
                    @error('fax')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='email' class="control-label">Email <b class="text-danger">*</b></label>
                    <input id='email' type="text" class="form-control @error('email') is-invalid @enderror" name='email' value="{{ old('email', $import->email ?? '') }}"  >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='website' class="control-label">Website </label>
                    <input id='website' type="text" class="form-control @error('website') is-invalid @enderror" name='website' value="{{ old('website', $import->website ?? '') }}"  >
                    @error('website')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='otherPhone' class="control-label">Contacto Alternativo </label>
                    <input id='otherPhone' type="text" class="form-control @error('otherPhone') is-invalid @enderror" name='otherPhone' value="{{ old('otherPhone', $import->otherPhone ?? '') }}"  >
                    @error('otherPhone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='init' class="control-label">Inicio de actividades <b class="text-danger">*</b></label></label>
                    <input id='init' type="text" class="form-control @error('init') is-invalid @enderror" name='init' value="{{ old('init', $import->init ?? '') }}" readonly="readonly">
                    @error('init')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="address" class="control-label">Endereço<b class="text-danger">*</b></label>
                    <textarea id="address" type="address" class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address', $import->address ?? '') }}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $import->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-edit"> editar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){ 
        $("#init").datepicker({
            'dateFormat': 'yy-mm-dd',
            'changeMonth': true,
            'changeYear': true
        });
    });
</script>
@endsection
