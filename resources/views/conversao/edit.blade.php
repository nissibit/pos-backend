@extends('conversao.indexConversao')
@section('content-conversao')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-edit"> Editar Conta</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('conversao.update', $conversao->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="customer_id" class="control-label">Nome <b class="text-danger">*</b></label>
                    <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $conversao->conversaoable->fullname ?? '') }}"  readonly="readonly" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="credit" class="control-label">Credito </label>
                    <input id="credit" type="text" class="form-control @error('credit') is-invalid @enderror" name="credit" value="{{ old('credit', $conversao->credit ?? '') }}"  >
                    @error('credit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="debit" class="control-label">Debito</label>
                    <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $conversao->debit ?? '') }}"  >
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
                    <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $conversao->balance ?? '') }}"  >
                    @error('balance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="discount" class="control-label">Desconto <b class="text-danger"> *</b></label>
                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount', $conversao->discount ?? '') }}"  >
                    @error('discount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>     
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="days" class="control-label">Dias para pagamento </label>
                    <input id="days" type="text" class="form-control @error('days') is-invalid @enderror" name="days" value="{{ old('days', $conversao->days ?? '') }}"  >
                    @error('days')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="extra_price" class="control-label">Percentagem extra nos produtos <b class="text-danger"> *</b></label>
                    <input id="extra_price" type="text" class="form-control @error('extra_price') is-invalid @enderror" name="extra_price" value="{{ old('extra_price', $conversao->extra_price ?? '') }}"  >
                    @error('extra_price')
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
