@extends('stock.indexStock')
@section('content-stock')
<div class="card">
    <div class="card-header">
        <i class="fas fa-box"> Registar Stock</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('stock.store') }}">
            {{ csrf_field() }}
            <div class="row input-group-sm">
                @if($product != null)
                <div class="form-group col-sm">
                    <label for="name" class="control-label">Produto <b class="text-danger">*</b></label>
                    <input type="text" class="form-control @error('product_id') is-invalid @enderror" name="product_name" id="product_name" value="{{ old('product_name', $stock->product_name ?? $product->name ?? '') }}"  readonly="readonly" />   
                    @error('product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @else

                <div class="form-group col-sm">
                    <label for="name" class="control-label">Seleccionar Produto <b class="text-danger">*</b></label>
                    <select class="form-control @error('product_id') is-invalid @enderror" id="product_combo" name="product_combo">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach(\App\Models\Product::all()->sortBy('name') ?? array() as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $dados['product_id'] ?? '') == $product->id ? 'selected' : '' }}>  {{ $product->name }}</option>                    
                        @endforeach
                        @error('product_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </select>
                </div>

                <div class="form-group col-sm">
                    <label for="barcode"><i class="fa fa-barcode"></i> Cod. barras</label>
                    <input type="text" class="form-control" name="barcode" id="barcode" value="{{ old('barcode', $stock->barcode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="othercode">Outro Codigo </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $stock->othercode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="name">Produto </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $stock->name ?? '') }}"  readonly="readonly" />                
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif
                <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ old('product_id', $stock->product_id ?? $product->id ?? '') }}"  readonly="readonly" />                

            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Armazem/Loja <b class="text-danger">*</b></label>
                    <select class="form-control @error('store_id') is-invalid @enderror" name="store_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($stores ?? array() as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $dados['store_id'] ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                        @endforeach
                    </select>
                    @error('store_id')
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
    <script type="text/javascript">
        $("#product_combo").on('change', function () {
            $('barcode').val('');
            $('othercode').val('');
//            $('#name').val(this.selectedIndex.text);
//            $('#product_id').val(this.value);
            getProduct(this.value, 'id');
        });
        $("#barcode").on('keyup', function () {
            var id = this.value;
            $('#othercode').val('');
            document.getElementById("product_combo").selectedIndex = 0;
            getProduct(id, 'barcode');
        });

        $("#othercode").on('keyup', function () {
            var id = this.value;
            $('#barcode').val('');
            document.getElementById("product_combo").selectedIndex = 0;
            getProduct(id, 'othercode');
        });
        function getProduct(id, searchBy) {
            var url = '{{ route("api.get.product") }}';
            $.ajax({
                'type': 'GET',
                'url': url,
                data: {id: id, searchBy},
                success: function (data) {
                    product = JSON.parse(data);
                    if (product !== null) {
                        $('#name').val(product.name);
                        $("#product_id").val(product.id);
                    } else {
                        $('#name').val('');
                        $('#product_id').val('');
                    }

                }
            });
        }

    </script>

    @endsection
