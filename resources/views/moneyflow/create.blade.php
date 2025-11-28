@extends('moneyflow.indexMoneyFlow')
@section('content-moneyflow')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-exchange"> Registar Entrada/Saida</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('moneyflow.store') }}">
            {{ csrf_field() }}
            <input type="hidden" name="fund_id"  id="fund_id" class="form-control @error('fund_id') is-invalid @enderror" value="{{ old('fund_id', $fund->id ?? $moneyflow->fund_id ?? '') }}"  >
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="type" class="control-label">Entrada/Saida <i class="fa fa-type"></i> </label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" >
                        <option value="Saida" >Saida</option>                        
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="amount" class="control-label">Valor</label>
                    <input type="text" name="amount"  id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $moneyflow->amount ?? '') }}"  >
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="reason" class="control-label">Motivo <b class="text-danger"> *</b></label>
                    <input type="text" name="reason"  id="reason" class="form-control @error('reason') is-invalid @enderror" value="{{ old('reason', $moneyflow->reason ?? '') }}"  >
                    @error('reason')
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
@endsection
