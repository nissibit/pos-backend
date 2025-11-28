@extends('admin.company.indexCompany')
@section('content-company')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-plus-circle"> Registar Empresa</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('company.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $company->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="tel" class="control-label">Telefone <b class="text-danger">*</b></label>
                    <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel', $company->tel ?? '') }}"  >
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
                    <input id="nuit" type="text" class="form-control @error('nuit') is-invalid @enderror" name="nuit" value="{{ old('nuit', $company->nuit ?? '') }}"  >
                    @error('nuit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='fax' class="control-label">Fax </label>
                    <input id='fax' type="text" class="form-control @error('fax') is-invalid @enderror" name='fax' value="{{ old('fax', $company->fax ?? '') }}"  >
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
                    <input id='email' type="text" class="form-control @error('email') is-invalid @enderror" name='email' value="{{ old('email', $company->email ?? '') }}"  >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='website' class="control-label">Website </label>
                    <input id='website' type="text" class="form-control @error('website') is-invalid @enderror" name='website' value="{{ old('website', $company->website ?? '') }}"  >
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
                    <input id='otherPhone' type="text" class="form-control @error('otherPhone') is-invalid @enderror" name='otherPhone' value="{{ old('otherPhone', $company->otherPhone ?? '') }}"  >
                    @error('otherPhone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for='init' class="control-label">Inicio de actividades <b class="text-danger">*</b></label></label>
                    <input id='init' type="text" class="form-control @error('init') is-invalid @enderror" name='init' value="{{ old('init', $company->init ?? '') }}" readonly="readonly">
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
                    <textarea id="address" type="address" class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address', $company->address ?? '') }}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $company->description ?? '') }}</textarea>
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
