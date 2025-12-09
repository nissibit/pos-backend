@extends('cashflow.indexCashFlow')
@section('content-cashflow')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-edit"> Editar Produto</i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('cashflow.update', $cashflow->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="barcode" class="control-label">Codigo de barras <i class="fa fa-barcode"></i> </label>
                    <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode', $cashflow->barcode ?? '') }}"  >
                    @error('barcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="othercode" class="control-label">Outro codigo</label>
                    <input id="othercode" type="text" class="form-control @error('othercode') is-invalid @enderror" name="othercode" value="{{ old('othercode', $cashflow->othercode ?? '') }}"  >
                    @error('othercode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>            
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $cashflow->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Abreviatura <b class="text-danger">*</b></label>
                    <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $cashflow->label ?? '') }}"  >
                    @error('label')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="category_id" class="control-label">Categoria <b class="text-danger">*</b></label>
                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($categories ?? array() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $cashflow->category_id ?? $dados['category_id'] ?? '') == $category->id ? 'selected' : '' }}>  {{ $category->name }}</option>                    
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="unity_id" class="control-label">Unidade <b class="text-danger">*</b></label>
                    <select class="form-control @error('unity_id') is-invalid @enderror" name="unity_id" id='unity_id'>
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($unities ?? array() as $unity)
                        <option value="{{ $unity->id }}" {{ old('unity_id', $cashflow->unity_id  ?? '') == $unity->id ? 'selected' : '' }}>  {{ $unity->name. ' ('.$unity->label.')' }}</option>                    
                        @endforeach
                    </select>
                    @error('unity_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="row col-sm-6 form-group input-group-sm">
                    <div class="col form-group input-group-sm">
                        <label for="rate" class="control-label">Taxa <b class="text-danger">*</b></label>
                        <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate', $cashflow->rate ?? '16') }}"  >
                        @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col form-group input-group-sm">
                        <label for="rate" class="control-label">Compra</label>
                        <input id="buying" type="text" class="form-control @error('buyingprice') is-invalid @enderror" name="buying" value="{{ old('buying', $cashflow->buyingprice ?? '') }}" onkeyup="findPrice()"  >

                    </div>
                    <div class="col form-group input-group-sm">
                        <label for="profit " class="control-label">Margem</label>
                        <input id="profit" type="text" class="form-control @error('profit') is-invalid @enderror" name="profit" value="{{ old('profit', $cashflow->profit ?? '20') }}"  onkeyup="findPrice()" >                        
                    </div>
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="price" class="control-label">Preco de venda (com taxa) <b class="text-danger">*</b></label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $cashflow->price ?? '') }}"  >
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
             <div class="row">
                <div class="col row">
                    <div class="col-sm-6 form-group input-group-sm">
                        <label for="run_out" class="control-label">Limite/aviso <b class="text-danger">*</b></label>
                        <input id="run_out" type="text" class="form-control @error('run_out') is-invalid @enderror" name="run_out" value="{{ old('run_out', $cashflow->run_out ?? '5') }}"  >
                        @error('run_out')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="col-sm-6 form-group input-group-sm">
                        <label for="flap" class="control-label">Retalho <b class="text-danger">*</b></label>
                        <input id="flap" type="text" class="form-control @error('flap') is-invalid @enderror" name="flap" value="{{ old('flap', $cashflow->flap ?? '5') }}"  >
                        @error('flap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $cashflow->description ?? '') }}</textarea>
                    @error('description')
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

<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $('#name').on('keyup', function (key) {
            $('#label').val(this.value.replace(/ /g, '_').toLowerCase());
        });
        
    });
    function findPrice() {
        var rate = $('#rate').val();
        var price = $('#buying').val();
        var profit = $('#profit').val();
        price = (price !== '' || price === undefined ? parseFloat(price) : 0);
        profit = (profit !== '' || profit === undefined ? parseFloat(profit) : 0);
        rate = (rate !== '' || rate === undefined ? parseFloat(rate) : 0);
        var total = ((price * profit) / 100) + price;
        $('#price').val(Math.round(total + (total * rate)/100));

    }
</script>
@endsection
