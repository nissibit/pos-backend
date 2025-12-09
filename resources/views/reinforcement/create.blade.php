@extends('reinforcement.indexReinforcement')
@section('content-reinforcement')
<div class="card">
    <div class="card-header">
        <i class="fas fa-box"> Registar Reinforcement</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('reinforcement.store') }}">
            {{ csrf_field() }}           
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Valor <b class="text-danger">*</b></label>
                    <input id="fund_id" type="hidden" class="form-control @error('fund_id') is-invalid @enderror" name="fund_id" value="{{  $fund->id }}"  >
                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount', $reinforcement->amount ?? '') }}"  >
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>     
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Descrição</label>
                    <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description" >{{ old('description', $reinforcement->description ?? '') }}</textarea>
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
 @endsection
