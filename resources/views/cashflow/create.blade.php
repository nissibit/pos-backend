@extends('cashflow.indexCashFlow')
@section('content-cashflow')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-exchange"> Registar Entrada/Saida</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('cashflow.store') }}">
            {{ csrf_field() }}
            <div class="row d-none">
                <input type="text" name="cashier_id"  id="cashier_id" class="form-control @error('cashier_id') is-invalid @enderror" value="{{ old('cashier_id', $cashier->id ?? $cashflow->cashier_id ?? '') }}"  >
                @error('cashier_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="type" class="control-label">Entrada/Saida <i class="fa fa-type"></i> </label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" >
                        <option value=""> ----- Seleccione ----- </option>
                        @foreach(App\Base::cashFlowType() ?? array() as $type)
                        <option value="{{ $type }}" {{ old('type', $cashflow ?? '')==$type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="amount" class="control-label">Valor</label>
                    <input type="text" name="amount"  id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $cashflow->amount ?? '') }}"  >
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
                    <input type="text" name="reason"  id="reason" class="form-control @error('reason') is-invalid @enderror" value="{{ old('reason', $cashflow->reason ?? '') }}"  >
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
