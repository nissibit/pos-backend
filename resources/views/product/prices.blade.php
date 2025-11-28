<div class="card">

    <div class="card-header">
        <form class="form-horizontal" method="POST" action="{{ route('price.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group col-sm">
                    <label for="price">Preco actual  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product->price ?? '0') }}" readonly="readonly" required="required" />                
                    <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $product->id }}" readonly="readonly"  />                           
                </div>
                <div class="form-group col-sm">
                    <label for="buying">Pr. Compra  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="buying" id="buying" value="{{ old('buying', $product->buying ?? '0') }}"  onkeyup="findPrice()" />                
                </div>
                <div class="form-group col-sm">
                    <label for="margen">M.Lucro (%)</label>
                    <input type="text" class="form-control" name="margen" id="margen" value="{{ old('margen', $product->margen ?? '0') }}"  required="required"  onkeyup="findPrice();"/>                
                </div>
                <div class="form-group col-sm">
                    <label for="current">Novo Preço  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="current" id="current" value="{{ old('current', $product->price ?? '0') }}"  required="required" onkeyup="calMargem();"/>                
                </div>
                <div class="col-sm-1 btn-group-sm ">
                    <label for="total" class="">&nbsp;</label>
                    <button type="submit" name="addEntry" id="addEntry" class="btn btn-success form-control">
                        <i class="fa fa-save"> </i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    @include("product.prices_table")
</div>
<script>
  function findPrice() {
        var price = $('#buying').val();
        var profit = $('#margen').val();
        price = (price !== '' || price === undefined ? parseFloat(price) : 0);
        profit = (profit !== '' || profit === undefined ? parseFloat(profit) : 0);
        var total = ((price * profit) / 100) + price;
        $('#current').val(Math.round(total ));

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
</script>