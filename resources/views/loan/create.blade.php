@extends('loan.indexLoan')
@section('content-loan')
<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
    }
</style>
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('loan.store') }}">
        {{ csrf_field() }}
        <input type="hidden" class="form-control" name="partner_id" id="partner_id" value="{{ old('partner_id', $partner->id ?? '') }}"   />                

        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3><i class="fa fa-plus-circle"> </i> Novo Empréstimo</h3>
                </div>
                <div class="col-sm-3 text-right">
                    <h2 id="QtdItems"></h2>
                </div>
            </div>
        </div>
        ,<style>
            input[readonly="readonly"]{
                font-weight: bold;        
                color: black;
            }
        </style>
        <div class="card-header">
            <div class="row">
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">@lang('messages.button.search') <i class="fa fa-search"></i> </label>
                    <input type="search" class="form-control" name="search" id="search" value="{{ old('search', $item->name ?? '') }}"   />                
                </div>

                <div class="form-group input-group-sm col-sm">
                    <label for="othercode">@lang('messages.product.othercode') </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $item->othercode ?? '') }}" />                
                </div>                
                <div class="form-group input-group-sm col-sm">
                    <label for="name">@lang('messages.item.product') </label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"  readonly="readonly" />                            
                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="stock"><i class="fa fa-stock"></i>@lang('messages.item.stock')</label>
                    <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock', $item->stock ?? '') }}"  />                
                </div>

            </div>
        </div>
        <div class="card-body" id="tabela-result">
            @include('layouts.items_added')
        </div>
        <div class="row form-group">
            <div class="col-sm input-group-sm">
                <label for="returned_date" class="control-label">Data de Devolução <i class="fas fa-asterisk text-danger"></i></label>
                <input   type="text"  name="returned_date" id="returned_date" class="form-control datepicker @error('returned_date') is-invalid @enderror" value="{{ old('returned_date', $loan->returned_date ?? \Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')) }}" readonly="readonly" />
                @error('returned_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm input-group-sm">
                <label for="description" class="control-label">Descrição</label>
                <textarea id="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $loan->description ?? '') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>   
        </div>
        <div class="card-footer">
            <input type="hidden" name="qtdItems" id="qtdItems"  />
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp; </label>
                    <button type="button" class="btn btn-success pull-right form-control" onclick="submitForm(this);">
                        <i class="fa fa-check-circle"> @lang('messages.prompt.finish')</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>
                    <a href="{{ route('cancel.items') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> @lang('messages.prompt.cancel')</i>
                    </a>
                </div>
            </div>
        </div>



    </form>
</div>
@include('layouts.script_items')
<script>
    $(function(){
       $('.datepicker').datepicker({
           dateFormat:  'yy-mm-dd'
       }) ;
    });
</script>
@endsection
