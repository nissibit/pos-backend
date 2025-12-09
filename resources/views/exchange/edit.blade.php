@extends('exchange.indexExchange')
@section('content-exchange')
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Cambio <b>{{$exchange->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('exchange.update', $exchange->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="currency_id" class="control-label">Moeda <b class="text-danger">*</b></label>
                    <select class="form-control @error('currency_id') is-invalid @enderror" name="currency_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($currencies ?? array() as $currency)
                        <option value="{{ $currency->id }}" {{ old('currency_id', $exchange->currency_id ?? '') == $currency->id ? 'selected' : '' }}>  {{ $currency->name.  ($currency->sign != null ? ' ('.$currency->sign.')' : '') }}</option>                    
                        @endforeach
                    </select>
                    @error('currency_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="amount" class="control-label">Valor <b class="text-danger">*</b></label>
                    <input id="amount" type="text" class="form-control @error('label') is-invalid @enderror" name="amount" value="{{ old('amount', $exchange->amount ?? '') }}"  >
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="day" class="control-label">Data <b class="text-danger">*</b></label>
                    <input id="day" type="text" class="form-control datepicker @error('label') is-invalid @enderror" name="day" value="{{ old('day', \Carbon\Carbon::today()->format('Y-m-d') ?? '') }}" readonly="readonly"  />
                    @error('day')
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
