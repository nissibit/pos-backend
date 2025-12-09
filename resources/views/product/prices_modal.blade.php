<div class="modal-header">
    <div class="card card-header ">
        <i class="fa fa-user fa-edit"> Editar preço do roduto {{ $product->name ?? "N/A" }}</i>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="form-horizontal" method="POST" action=""> {{ csrf_field() }}
    <div class="modal-body" >
        <div id="msgEditPriceProduct"></div>
        <div class="row">
            <div class="form-group col-sm">
                <label for="price">Preco actual  <b class="text-danger"> *</b></label>
                <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product->price ?? '0') }}" readonly="readonly" required="required" />                
                <input type="hidden" class="form-control" name="id_modal" id="id_modal" value="{{ $product->id }}"  />                           
            </div>
            <div class="form-group col-sm">
                <label for="buying_modal">Pr. Compra  <b class="text-danger"> *</b></label>
                <input type="text" class="form-control" name="buying_modal" id="buying_modal" value="{{ old('buying_modal', $product->buying_modal ?? '0') }}"  onkeyup="findPriceModal()" />                
            </div>
            <div class="form-group col-sm">
                <label for="margen_modal">M.Lucro (%)</label>
                <input type="text" class="form-control" name="margen_modal" id="margen_modal" value="{{ old('margen_modal', $product->margen_modal ?? '0') }}"  required="required"  onkeyup="findPriceModal();"/>                
            </div>
            <div class="form-group col-sm">
                <label for="current_modal">Novo Preço  <b class="text-danger"> *</b></label>
                <input type="text" class="form-control" name="current_modal" id="current_modal" value="{{ old('current_modal', $product->price ?? '0') }}"  required="required" onkeyup="calMargem();"/>                
            </div>            
        </div>
        <div class="row">
            <div class="col-sm btn-group-sm ">
                <button type="button" name="addEntry" id="addEntry" class="btn btn-primary form-control">
                    <i class="fa fa-save"> </i>
                </button>
            </div>
        </div>
        @include("product.prices_table")
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="callRetalho()">Fechar</button>
        <button type="button" onclick="editPrice();" class="btn btn-success pull-right">
            <i class="fa fa-check-circle"> editar</i>
        </button>
    </div>
</form>
<script>
    function findPriceModal() {
        var price = $('#buying_modal').val();
        var profit = $('#margen_modal').val();
        price = (price !== '' || price === undefined ? parseFloat(price) : 0);
        profit = (profit !== '' || profit === undefined ? parseFloat(profit) : 0);
        var total = ((price * profit) / 100) + price;
        $('#current_modal').val(Math.round(total));

    }
    function calMargem() {
        var buying_modal = $('#buying_modal').val();
        var current_modal = $('#current_modal').val();
        buying_modal = (buying_modal !== '' || buying_modal === undefined ? parseFloat(buying_modal) : 0);
        current_modal = (current_modal !== '' || current_modal === undefined ? parseFloat(current_modal) : 0);
        if (buying_modal !== 0 && current_modal !== 0) {
            var margem = ((current_modal - buying_modal) / buying_modal) * 100;
            $('#margen_modal').val(Math.round(margem));
        } else {
            $('#margen_modal').val(0);
        }
    }
    
    function editPrice() {
        var url = '{{ route("api.product.price.update.modal") }}';
        var id = $('#id_modal').val();
        var product_id = id;
        var buying = $('#buying_modal').val();
        var margen = $('#margen_modal').val();
        var current = $('#current_modal').val();

        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, product_id: product_id,buying: buying, margen:margen, current:current},
            success: function (data) {
                $('#msgEditPriceProduct').html(data);
                callRetalho();
            }
        });
    }
</script>