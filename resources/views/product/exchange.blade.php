@extends('stock.indexStock')
@section('content-stock')
<div class="card">
    <div class="card-header">
        <i class="fas fa-exchange"> Transferir Stock</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('product.exchange.post') }}">
            {{ csrf_field() }}
            <div class="row input-group-sm">
                <div class="form-group col-sm input-group-sm">
                    <label for="name" class="control-label">Produto <b class="text-danger">*</b></label>
                    <input type="text" class="form-control @error('product_id') is-invalid @enderror" name="product_name" id="product_name" value="{{ old('product_name', $stock->product_name ?? $product->name ?? '') }}"  readonly="readonly" />   
                    @error('product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm input-group-sm">
                    <label for="label" class="control-label">Stock <b class="text-danger">*</b></label>
                    <input id="quantity" type="quantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $stock->quantity ?? '') }}" readonly="reaonly" >
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm input-group-sm">
                    <label for="label" class="control-label">Retalho <b class="text-danger">*</b></label><br />

                    <label class="control-label">
                        <input type="radio" name="flap_radio" id="flap_1" value="{{ $product->flap }}" checked="checked" onclick="changeRetalho(this);" /> Ret 1
                    </label> &nbsp;&nbsp;
                    <label class="control-label">
                        <input type="radio" name="flap_radio" id="flap_12" value="{{ $product->flap_12 }}" onclick="changeRetalho(this);"  /> Ret 1/2
                    </label> &nbsp;&nbsp;
                    <label class="control-label">
                        <input type="radio" name="flap_radio" id="flap_14" value="{{ $product->flap_14 }}" onclick="changeRetalho(this);"  /> Ret 1/4
                    </label> &nbsp;&nbsp;
                    <label class="control-label">
                        <input type="radio" name="flap_radio" id="flap_18" value="{{ $product->flap_18 }}" onclick="changeRetalho(this);"  /> Ret 1/8
                    </label>

                </div>
                <div class="form-group col-sm row">
                    <div class="form-group col-sm input-group-sm">
                        <label for="label" class="control-label">Qtd. <b class="text-danger">*</b></label>
                        <input id="flap" type="flap" class="form-control @error('flap') is-invalid @enderror" name="flap" value="{{ old('flap', $product->flap ?? '') }}" readonly="readonly" />
                        @error('flap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm input-group-sm">
                        <label for="label" class="control-label">Transferir <b class="text-danger">*</b></label>
                        <input id="send_quantity" type="send_quantity" class="form-control @error('send_quantity') is-invalid @enderror" name="send_quantity" value="{{ old('send_quantity', '') }}" required="required"  />
                        @error('send_quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ old('product_id', $stock->product_id ?? $product->id ?? '') }}"  readonly="readonly" />                
            </div>
            <div class="row">
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Destino <i class="fa fa-search"></i> </label>
                    <input type="search" class="form-control" name="search" id="search" value="{{ old('search', $item->name ?? '') }}"   />                
                </div>               
                <div class="form-group input-group-sm col-sm">
                    <label for="name">Produto Destino</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"  readonly="readonly" required="required" />                            
                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="stock"><i class="fa fa-stock"></i> Stock Destino</label>
                    <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock', $item->stock ?? '') }}" readonly="readonly" />                
                </div>
                <input type="hidden" class="form-control" name="product_destin" id="product_destin" value="{{ old('product_destin', $stock->product_destin ?? $product->id ?? '') }}"  readonly="readonly" />                
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-primary pull-right">
                        <i class="fa fa-check-circle"> guardar</i>
                    </button>
                </div>
            </div>
        </form>

    </div>
    <script type="text/javascript">
        $("#search").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                $('#search').focus();
                $('#search').val('');
                getProduct(ui.item.id, 'id');
                return false;
            }
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
                        $('#product_destin').val(product.id);
                        $('#name').val(product.name);
//                        $('#search').val(product.name);
                        $('#stock').val(product.description);
                    } else {
                        $('#name').val('');
                    }

                }
            });
        }
        function changeRetalho(obj){
            if(obj.checked){
                $("#flap").val(obj.value);
            }
        }
    </script>
    @endsection
