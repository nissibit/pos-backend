<form action="" name="formGood" id="formGood">
     <div class="card-header">
        <div class="row">
           
            <div class="form-group input-group-sm col-sm ui-widget" >
                <input type="hidden" name="good_id" id="good_id">
                <label for="name">Produto <i class="fa fa-asterisk text-danger"></i> </label>
                    @foreach($goods as $good)
                        <div class="form-check">
                            <label class="form-check-label" style="cursor: pointer;">

                                <input type="radio" value="{{$good->id}}" data-gid="{{$good->id}}" data-price="{{ $good->price}}" data-label="{{ $good->label }}"  data-barcode="{{ $good->barcode }}" onchange="displayGood(this)" class="form-check-input" name="good_id">{{$good->name}}
                              </label>
                        </div>
                    @endforeach
            </div>
            <div class="form-group input-group-sm col-sm">
                <label for="good_name">Designação <i class="fa fa-asterisk text-danger"></i></label>
                <input type="hidden" class="form-control" name="good_barcode" id="good_barcode" value="{{ old('good_barcode', $item->good_barcode ?? '') }}" />                
                <input type="text" class="form-control" name="good_name" id="good_name" value="{{ old('good_name', $item->good_name ?? '') }}" />                
            </div>                
           
            <div class="form-group input-group-sm col-sm">
                <label for="good_price">Preço <i class="fa fa-asterisk text-danger"></i></label>
                <input type="text" class="form-control" name="good_price" id="good_price" value="{{ old('good_price', $item->good_price ?? '') }}" onkeyup="calcularTotal()" />                
            </div>

            <div class="form-group input-group-sm col-sm">
                <label for="good_quantity">Qtd. <i class="fa fa-asterisk text-danger"></i> </label>
                <input type="text" class="form-control" name="good_quantity" id="good_quantity" value="{{ old('good_quantity', $item->good_quantity ?? '') }}" onkeyup="calcularTotal();" />                
            </div>


            <div class="form-group input-group-sm col-sm">
                <label for="good_total"><i class="fa fa-asterisk text-danger"></i>Total</label>
                <input type="text" class="form-control" name="good_total" id="good_total" value="{{ old('good_total', $item->good_total ?? '') }}" readonly="readonly" />                
            </div>

            <div class="form-group input-group-sm col-sm">
                <br />
                <button type="button" class="btn btn-outline-primary" id="btnAddGood" onclick="addGood()"  >
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>
</form>