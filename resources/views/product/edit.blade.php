@extends('product.indexProduct')
@section('content-product')
<div class="card">
    <div class="card-header">
        <i class="fa fa-user fa-edit"> Editar Produto</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('product.update', $product->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
              
                    <label for="barcode" class="control-label">Codigo de barras <i class="fa fa-barcode"></i> </label>
                    <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}"  >
                    @error('barcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="othercode" class="control-label">Outro codigo</label>
                    <input id="othercode" type="text" class="form-control @error('othercode') is-invalid @enderror" name="othercode" value="{{ old('othercode', $product->othercode ?? '') }}"  >
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
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name ?? '') }}"  >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Abreviatura <b class="text-danger">*</b></label>
                    <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $product->label ?? '') }}"  >
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
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? $dados['category_id'] ?? '') == $category->id ? 'selected' : '' }}>  {{ $category->name }}</option>                    
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
                        <option value="{{ $unity->id }}" {{ old('unity_id', $product->unity_id  ?? '') == $unity->id ? 'selected' : '' }}>  {{ $unity->name. ' ('.$unity->label.')' }}</option>                    
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
                        <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate', $product->rate ?? '16') }}" readonly="readonly"  >
                        @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col form-group input-group-sm">
                        <label for="buying" class="control-label">Compra <b class="text-danger">*</b></label>
                        <input id="buying" type="text" class="form-control @error('buying') is-invalid @enderror" name="buying" value="{{ old('buying', $product->buying ?? '') }}" onkeyup="findPrice()"  >
                        @error('buying')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col form-group input-group-sm">
                        <label for="margem " class="control-label">Margem</label>
                        <input id="margem" type="text" class="form-control @error('margem') is-invalid @enderror" name="margem" value="{{ old('margem', $product->margem ?? '') }}"  onkeyup="findPrice()" >                        
                    </div>
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="price" class="control-label">Preco de venda (com taxa) <b class="text-danger">*</b></label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price ?? '') }}"  >
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="run_out" class="control-label">Limite/aviso <b class="text-danger">*</b></label>
                    <input id="run_out" type="text" class="form-control @error('run_out') is-invalid @enderror" name="run_out" value="{{ old('run_out', $product->run_out ?? '5') }}"  >
                    @error('run_out')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div> 
                @can("change_search_product")
                <div class="col-sm-6 form-group input-group-lg">
                    <label class="control-label">&nbsp;</label>

                    <div class="form-check">
                        <label for="search" class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="search" id="search"{{ old('search', $product->search ?? false) ? 'checked' : '' }}  />
                                   Pesquisar ?
                        </label>
                    </div>
                    @error('search')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endcan
                <div class="row col-sm-6 form-group input-group-sm d-none">
                    <div class="col-sm form-group input-group-sm">
                        <label for="flap" class="control-label">Retalho <b class="text-danger">*</b></label>
                        <input id="flap" type="text" class="form-control @error('flap') is-invalid @enderror" name="flap" value="{{ old('flap', $product->flap ?? '5') }}"  >
                        @error('flap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="col-sm form-group input-group-sm">
                        <label for="flap_12" class="control-label">Ret. 1/2</label>
                        <input id="flap_12" type="text" class="form-control @error('flap_12') is-invalid @enderror" name="flap_12" value="{{ old('flap_12', $product->flap_12 ?? '1') }}"  >
                        @error('flap_12')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="col-sm form-group input-group-sm">
                        <label for="flap_14" class="control-label">Ret. 1/4</label>
                        <input id="flap_14" type="text" class="form-control @error('flap_14') is-invalid @enderror" name="flap_14" value="{{ old('flap_14', $product->flap_14 ?? '1') }}"  >
                        @error('flap_14')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="col-sm form-group input-group-sm">
                        <label for="flap_18" class="control-label">Ret. 1/8</label>
                        <input id="flap_18" type="text" class="form-control @error('flap_18') is-invalid @enderror" name="flap_18" value="{{ old('flap_18', $product->flap_18 ?? '1') }}"  >
                        @error('flap_18')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col btn-group-sm text-right ">
                    <label for="" class="control-label">&nbsp;</label><br />
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-check-circle"> editar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include("product.scripts")
@endsection
