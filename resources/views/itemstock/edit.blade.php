@extends('itemstock.indexItemStock')
@section('content-itemstock')
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Produto <b>{{$itemstock->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('itemstock.update', $itemstock->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
             <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Produto <b class="text-danger">*</b></label>
                    <input type="hidden" name="stock_taking_id" id="stock_taking_id" value="{{ $stocktaking->id }}"  />
                    <input type="hidden" name="product_id" id="product_id" value="{{ $itemstock->product_id }}"  />
                    <input type="text" name="name" id="product_id" class="form-control @error('product_id') @enderror" value="{{ $itemstock->product->name }}" readonly="readonly"  />
                    @error('product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>  
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Quatidade <b class="text-danger">*</b></label>
                    <input id="quantity" type="quantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $itemstock->quantity ?? '') }}"  >
                    @error('quantity')
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
<script type="text/javascript">
    $("#product_combo").on('change', function () {
        $('barcode').val('');
        $('othercode').val('');
        $('#name').val(this.selectedIndex.text);
        $('#product_id').val(this.value);
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