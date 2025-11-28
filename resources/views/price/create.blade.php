@extends('price.indexPrice')
@section('content-price')
<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col">
                <h1><i class="fas fa-edit"> Alteração de preços</i></h1>
            </div>
            <div class="col">
                <div class="card">
                    <h2 class="card-header"><b>Ultimo produto alterado</b></h2>
                    <dl class="card-body text-right">
                        <dt>{{ strtoupper($last->name ?? "N/A") }}</dt>
                        <dd>{{ number_format($last->price ?? 0, 2). " MT" }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('price.store') }}">
            {{ csrf_field() }}

            <div class="row">
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">@lang('messages.button.search') <i class="fa fa-search"></i> </label>
                    <input type="search" class="form-control" name="search" id="search" value="{{ old('search', '') }}"   />                
                    <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ old('product_id', '') }}"   />                
                </div>

                <div class="form-group input-group-sm col-sm">
                    <label for="othercode">@lang('messages.product.othercode') </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $item->othercode ?? '') }}" />                
                </div>                
                <div class="form-group input-group-sm col-sm">
                    <label for="name">@lang('messages.item.product') </label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', '') }}"  readonly="readonly" />                            
                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="stock"><i class="fa fa-stock"></i>@lang('messages.item.stock')</label>
                    <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock', $item->stock ?? '') }}" readonly="readonly" />                
                </div>

            </div>
            <div class="row">
                <div class="form-group col-sm">
                    <label for="price">Preco actual  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price', '0') }}" readonly="readonly" required="required" />                
                </div>
                <div class="form-group col-sm">
                    <label for="buying">Pr. Compra  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="buying" id="buying" value="{{ old('buying', $product->buying ?? '0') }}"  onkeyup="findPrice()" />                
                </div>
                <div class="form-group col-sm">
                    <label for="margen">M.Lucro (%)</label>
                    <input type="text" class="form-control" name="margen" id="margen" value="{{ old('margen', $product->margen ?? '0') }}"  required="required"  onkeyup="findPrice()"/>                
                </div>
                <div class="form-group col-sm">
                    <label for="current">Novo Preço  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="current" id="current" value="{{ old('current', $product->price ?? '0') }}"  required="required" onkeyup="calMargem()" />                
                </div>
                <div class="col-sm-1 btn-group-sm ">
                    <label for="total" class="">&nbsp;</label>
                    <button type="submit" name="addEntry" id="addEntry" class="btn btn-success form-control">
                        <i class="fa fa-save"> </i>
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col" id="historico">

            </div>
        </div>
    </div>
</div>
<script>
    function getProduct(id, searchBy) {
        var url = '{{ route("api.get.product") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, searchBy},
            success: function (data) {
                product = JSON.parse(data);
                if (product !== null) {
                    $('#product_id').val(product.id);
                    $('#name').val(product.name);
                    $('#price').val(product.price);
                    $('#stock').val(product.description);
                    getHistorico(product.id);
                } else {
                    $('#name').val('');
                }

            }
        });
    }
    function findPrice() {
        var price = $('#buying').val();
        var profit = $('#margen').val();
        price = (price !== '' || price === undefined ? parseFloat(price) : 0);
        profit = (profit !== '' || profit === undefined ? parseFloat(profit) : 0);
        var total = ((price * profit) / 100) + price;
        $('#current').val(Math.round(total));
    }
    function calMargem() {
        var buying = $('#buying').val();
        var current = $('#current').val();
        buying = (buying !== '' || buying === undefined ? parseFloat(buying) : 0);
        current = (current !== '' || current === undefined ? parseFloat(current) : 0);
        if (buying !== 0 && current !== 0) {
            var margem = ((current - buying) / buying) * 100;
            $('#margen').val(Math.round(margem));
        } else {
            $('#margen').val(0);
        }
    }
    document.addEventListener('DOMContentLoaded', function(){ 
        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                getProduct(ui.item.id, 'id');
                $('#search').val('');
                $('#search').focus();
                return false;
            }
        });
    });

    function getHistorico(cod) {
        var url = '{{ route("price.by.product") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: cod},
            success: function (data) {
                $('#historico').html(data);
            },
            error: function (error) {
                $('#historico').html(error);
            }
        });
    }
</script>
@endsection