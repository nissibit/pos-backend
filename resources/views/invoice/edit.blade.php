@extends('invoice.indexInvoice')
@section('content-invoice')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-edit"> Editar Produto</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('invoice.update', $invoice->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="server_id" class="control-label">Cliente <b class="text-danger">*</b></label>
                    <select class="form-control @error('server_id') is-invalid @enderror" name="server_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($servers ?? array() as $server)
                        <option value="{{ $server->id }}" {{ old('server_id', $invoice->server_id ?? '') == $server->id ? 'selected' : '' }}>  {{ $server->fullname }}</option>                    
                        @endforeach
                    </select>
                    @error('server_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="invoice" class="control-label">Invoiceo </label>
                    <input id="invoice" type="text" class="form-control @error('invoice') is-invalid @enderror" name="invoice" value="{{ old('invoice', $invoice->invoice ?? '') }}"  >
                    @error('invoice')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="debit" class="control-label">Debito</label>
                    <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $invoice->debit ?? '') }}"  >
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
                    <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $invoice->balance ?? '') }}"  >
                    @error('balance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="discount" class="control-label">Desconto <b class="text-danger"> *</b></label>
                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount', $invoice->discount ?? '') }}"  >
                    @error('discount')
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
@endsection
