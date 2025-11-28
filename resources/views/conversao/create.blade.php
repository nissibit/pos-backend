@extends('conversao.indexConversao')
@section('content-conversao')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-plus-circle"> Registar Conta</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('conversao.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="customer_id" class="control-label">Cliente <b class="text-danger">*</b></label>
                    <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($customers ?? array() as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $conversao->customer_id  ?? '') == $customer->id ? 'selected' : '' }}>  {{ $customer->fullname }}</option>                    
                        @endforeach
                    </select>
                    @error('customer_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="credit" class="control-label">Credito </label>
                    <input id="credit" type="text" class="form-control @error('credit') is-invalid @enderror" name="credit" value="{{ old('credit', $conversao->credit ?? '0') }}"  >
                    @error('credit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="debit" class="control-label">Debito</label>
                    <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $conversao->debit ?? '0') }}"  >
                    @error('debit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>            
           
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="balance" class="control-label">Saldo </label>
                    <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $conversao->balance ?? '0') }}"  >
                    @error('balance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="discount" class="control-label">Desconto <b class="text-danger"> *</b></label>
                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount', $conversao->discount ?? '0') }}"  >
                    @error('discount')
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
