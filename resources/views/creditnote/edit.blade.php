@extends('creditnote.indexCreditNote')
@section('content-creditnote')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-edit"> Editar Produto</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('creditnote.update', $creditnote->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="account_id" class="control-label">Cliente <b class="text-danger">*</b></label>
                    <select class="form-control @error('account_id') is-invalid @enderror" name="account_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($accounts ?? array() as $account)
                        <option value="{{ $account->id }}" {{ old('account_id', $creditnote->account_id ?? '') == $account->id ? 'selected' : '' }}>  {{ $account->fullname }}</option>                    
                        @endforeach
                    </select>
                    @error('account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="creditnote" class="control-label">creditnoteo </label>
                    <input id="creditnote" type="text" class="form-control @error('creditnote') is-invalid @enderror" name="creditnote" value="{{ old('creditnote', $creditnote->creditnote ?? '') }}"  >
                    @error('creditnote')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="debit" class="control-label">Debito</label>
                    <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $creditnote->debit ?? '') }}"  >
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
                    <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $creditnote->balance ?? '') }}"  >
                    @error('balance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="discount" class="control-label">Desconto <b class="text-danger"> *</b></label>
                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount', $creditnote->discount ?? '') }}"  >
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
