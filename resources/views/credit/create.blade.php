@extends('credit.indexCredit')
@section('content-credit')
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('credit.store') }}">
        {{ csrf_field() }}
        <div class="card-header">
            <h3><i class="fa fa-book-open"> </i> Credito para "<strong> {{ $account->accountable->fullname }}</strong>"</h3>
            <input type="hidden" name="account_id" id="account_id" value="{{ $account->id }}" />
            <input type="hidden" class="datepicker" name="day" id="day" value="{{ old('day',$credit->day ?? \Carbon\Carbon::today()->format('Y-m-d')) }}" readonly="readonly" />
            <select class="form-control input-group-sm @error('store_id') is-invalid @enderror" name="store_id">
                @foreach($stores ?? array() as $store)
                <option value="{{ $store->id }}" {{ old('store_id', $dados['store_id'] ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                @endforeach
            </select>

            <div class="row">           
                <div class="form-group col-sm">
                    <label for="nr_requisicao">Nr. Requisição <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control @error('nr_requisicao') is-invalid @enderror" name="nr_requisicao" id="nr_requisicao" value="{{ old('nr_requisicao', $item->nr_requisicao ?? '') }}" />                
                    @error('nr_requisicao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm">
                    <label for="nr_factura">Nr. Fcatura <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control @error('nr_factura') is-invalid @enderror" name="nr_factura" id="nr_factura" value="{{ old('nr_factura', $item->nr_factura ?? '') }}" />                
                    @error('nr_factura')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        @include('layouts.items')
    </form>
</div>
@endsection