@extends('customer.indexCustomer')
@section('content-customer')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-user"> Registar Cliente</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('customer.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="fullname" class="control-label">Nome completo / Designação <b class="text-danger">*</b></label>
                    <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $customer->fullname ?? '') }}"  >
                    @error('fullname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
               <div class="col-sm-6 form-group input-group-sm">
                    <label for="nuit" class="control-label">NUIT <b class="text-danger">*</b></label>
                    <input id="nuit" type="text" class="form-control @error('nuit') is-invalid @enderror" name="nuit" value="{{ old('nuit', $customer->nuit ?? '') }}"  >
                    @error('nuit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>            
            
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="type" class="control-label">Tipo de Cliente <b class="text-danger">*</b></label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach(\App\Base::tipoCliente() ?? array() as $type)
                        <option value="{{ $type }}" {{ old('type', $customer->type ?? '') == $type ? 'selected' : '' }}>  {{ $type }}</option>                    
                        @endforeach
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="document_type" class="control-label">Tipo de Documento </label>
                    <select class="form-control @error('document_type') is-invalid @enderror" name="document_type" id='document_type'>
                        <option value=""> ----- Selecciona Tipo de Documento ----- </option>
                        @foreach(\App\Base::tipoDoc() ?? array() as $document_type)
                        <option value="{{ $document_type }}" {{ old('document_type', $customer->document_type ?? '') == $document_type ? 'selected' : '' }}>  {{ $document_type }}</option>                    
                        @endforeach
                    </select>
                    @error('document_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="document_number" class="control-label">Nr. Documento</label>
                    <input id="document_number" type="text" class="form-control @error('document_number') is-invalid @enderror" name="document_number" value="{{ old('document_number', $customer->document_number ?? '') }}"  >
                    @error('document_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="phone_nr" class="control-label">Telefone <b class="text-danger">*</b></label>
                    <input id="phone_nr" type="text" class="form-control @error('phone_nr') is-invalid @enderror" name="phone_nr" value="{{ old('phone_nr', $customer->phone_nr ?? '') }}"  >
                    @error('phone_nr')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
               <div class="col-sm-6 form-group input-group-sm">
                    <label for="email" class="control-label">Email</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $customer->email ?? '') }}"  >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
               <div class="col-sm-6 form-group input-group-sm">
                    <label for="phone_nr_2" class="control-label">Outro telefone</label>
                    <input id="phone_nr_2" type="text" class="form-control @error('phone_nr_2') is-invalid @enderror" name="phone_nr_2" value="{{ old('phone_nr_2', $customer->phone_nr_2 ?? '') }}"  >
                    @error('phone_nr_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="address" class="control-label">Endereço <b class="text-danger">*</b></label>
                    <textarea id="address"  type="address"  name="address" class="form-control @error('address') is-invalid @enderror" >{{ old('address', $customer->address ?? '') }}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $customer->description ?? '') }}</textarea>
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
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $('#name').on('keyup', function (key) {
           $('#label').val(this.value.replace(/ /g, '_').toLowerCase());
        });

    });
</script>

@endsection
