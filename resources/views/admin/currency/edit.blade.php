@extends('admin.currency.indexCurrency')
@section('content-currency')
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Moeda <b>{{$currency->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('currency.update', $currency->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $currency->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Abreviatura <b class="text-danger">*</b></label>
                    <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $currency->label ?? '') }}"  >
                    @error('label')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="sign" class="control-label">Simbolo</label>
                    <input type="text" id="sign"  type="sign"  name="sign" class="form-control @error('sign') is-invalid @enderror" value="{{ old('sign', $currency->sign ?? '') }}" />
                    @error('sign')
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
