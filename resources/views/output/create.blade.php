@extends('output.indexOutput')
@section('content-output')
<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
    }
</style>
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('output.store') }}">
        {{ csrf_field() }}
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3><i class="fa fa-arrow-circle-up"> </i> Nova Saída</h3>
                    <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}" />
                    <input type="hidden" class="datepicker" name="day" id="day" value="{{ old('day',$output->day ?? \Carbon\Carbon::today()->format('Y-m-d')) }}" readonly="readonly" />           
                </div>
                <div class="col-sm-3 text-right">
                    <h2 id="QtdItems"></h2>
                </div>
            </div>
        </div>
        @include('layouts.items')
    </form>
</div>
@endsection