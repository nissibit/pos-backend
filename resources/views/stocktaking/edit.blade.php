@extends('stocktaking.indexStockTaking')
@section('content-stocktaking')
<div class="card">
    <div class="card-header">
        <i class="fa fa-check"> Fechar Inventário <b>{{$stocktaking->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('stocktaking.update', $stocktaking->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }} 
            <div class="row card-header">
                <div class="col">
                    <strong>Loja/Armazém</strong>
                    {{ $stocktaking->store->name }}                        
                </div>
                <div class="col">
                    <strong>Produtos verificados</strong>
                    {{ $stocktaking->products->count() }}                        
                </div>
            </div>
            <div class="row">                  
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Observação </label>
                    <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $stocktaking->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-primary pull-right">
                        <i class="fa fa-check-circle"> fechar</i>
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