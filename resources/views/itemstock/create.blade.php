@extends('itemstock.indexItemStock')
@section('content-itemstock')
<style>
    input[readonly="readonly"]{
        font-weight: bold;
        color: black;
    }
</style>
<div class="card">
    <div class="card-header">
        <i class="fas fa-calculator"> Iniciar um Inventário</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('itemstock.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Produto <b class="text-danger">*</b></label>
                    <input type="hidden" name="stock_taking_id" id="stock_taking_id" value="{{ $stocktaking->id }}"  />
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}"  />
                    <input type="text" name="name" id="product_id" class="form-control @error('product_id') @enderror" value="{{ $product->name }}" readonly="readonly"  />
                    @error('product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>  
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Quatidade <b class="text-danger">*</b></label>
                    <input id="quantity" type="quantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $stock->quantity ?? '') }}"  >
                    @error('quantity')
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
    <script>
        $('#quantity').focus();
    </script>
    @endsection
