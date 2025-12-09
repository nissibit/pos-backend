@extends('invoice.indexInvoice')
@section('content-invoice')
<style>
    input[readonly="reaonly"]{
        font-weight: bold;
        color: black;
    }
</style>
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('invoice.store') }}">
        {{ csrf_field() }}
        <div class="card-header">
            <h3><i class="fa fa-book-open"> </i> Factura para fornecedor "<strong> {{ $server->fullname }}</strong>"</h3>            
            <div class="col-sm-2">
                <input type="hidden" name="server_id" id="server_id" value="{{ $server->id }}" />
                <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}" />
                <input type="hidden" name="account_id" id="account_id" value="{{ $server->account->id }}" />
                <input type="hidden" class="datepicker" name="day" id="day" value="{{ old('day',$invoice->day ?? \Carbon\Carbon::today()->format('Y-m-d')) }}"  />

            </div>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Procurar <i class="fa fa-search"></i> </label>
                    <input type="search" class="form-control" name="search" id="search" value="{{ old('search', $item->name ?? '') }}"   />                
                </div>
                <div class="form-group col-sm d-none">
                    <label for="barcode"><i class="fa fa-barcode"></i> Cod. barras</label>
                    <input type="text" class="form-control" name="barcode" id="barcode" value="{{ old('barcode', $entry->barcode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="othercode">Código </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $entry->othercode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="name">Nome </label>

                    <input type="text" class="form-control disabled" name="name" id="name" value="{{ old('name', $entry->name ?? '') }}"  />                
                    <input type="hidden" class="form-control " name="product_id" id="product_id" value="{{ old('product_id', $entry->product_id ?? '') }}"   />                
                </div>
                <div class="form-group col-sm">
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="rate">Stock </label>
                            <input type="text" class="form-control" name="stock" id="stock" id="stock" value="{{ old('stock', $entry->stock ?? '0') }}" readonly="readonly" />                
                        </div>
                        <div class="form-group col-sm">
                            <label for="rate">Imposto </label>
                            <input type="text" class="form-control" name="rate" id="rate" value="{{ old('rate', $entry->rate ?? '0') }}" />                
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-1">
                    <label for="quantity">Qtd.  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $entry->quantity ?? '1') }}" />                
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm">
                    <label for="old_price">Preco actual  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="old_price" id="old_price" value="{{ old('old_price', $entry->old_price ?? '0') }}" readonly="readonly"  />                
                </div>
                <div class="col-sm form-group input-group-sm">
                    <label for="currency_id" class="control-label">Moeda <b class="text-danger">*</b></label>
                    <select class="form-control @error('currency_id') is-invalid @enderror" name="currency_id" id="currency_id">
                        <option value="MT">MT</option>
                        @foreach($currencies ?? array() as $currency)
                        <option value="{{ $currency->id }}" {{ old('currency_id',  $exchange->currency_id ?? '') == $currency->id ? 'selected' : '' }}>  {{ $currency->name.  ($currency->sign != null ? ' ('.$currency->sign.')' : '') }}</option>                    
                        @endforeach
                    </select>
                    @error('currency_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm">
                    <label for="buying_price_before">Pr. Compra  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="buying_price_before" id="buying_price_before" value="{{ old('buying_price_before', $entry->buying_price_before ?? '0') }}" onkeyup="buying_price.value = (this.value * exchange.value);"  />                
                </div>                
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Cambio <i class="fa fa-exchange"></i> </label>                               
                    <input type="exchange" class="form-control" name="exchange" id="exchange" value="{{ old('exchange', $item->exchange ?? '1') }}"  readonly="readonly"   />                
                </div>
                <div class="form-group col-sm">
                    <label for="buying_price">V. MZN <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="buying_price" id="buying_price" value="{{ old('buying_price', $entry->buying_price ?? '0') }}"  readonly="readonly"  />                
                </div> 
                <div class="form-group col-sm">
                    <label for="profit">M.Lucro (%)</label>
                    <input type="text" class="form-control" name="profit" id="profit" value="{{ old('profit', $entry->profit ?? '0') }}"  />                
                </div>
                <div class="form-group col-sm">
                    <label for="current_price">Pr. Actual  <b class="text-danger"> *</b></label>
                    <input type="text" class="form-control" name="current_price" id="current_price" value="{{ old('current_price', $entry->current_price ?? '0') }}"  />                
                </div>
                <div class="col-sm-1 btn-group-sm ">
                    <label for="total" class="">&nbsp;</label>
                    <button type="button" name="addEntry" id="addEntry" class="btn btn-success form-control">
                        <i class="fa fa-plus"> </i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>Qtd</th>
                        <th>Designacao</th>
                        <th>P.Unitário</th>
                        <!-- <th>Imposto (%)</th> -->
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tbody">  
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="form-group col-sm d-none">
                    <label for="subtotal">SubTotal </label>
                    <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ old('subtotal', $entry->subtotal ?? '0') }}" readonly="readonly" />                
                </div>

                <div class="form-group col-sm d-none">
                    <label for="totalrate">Total Imposto </label>
                    <input type="text" class="form-control" name="totalrate" id="totalrate" value="{{ old('totalrate', $entry->totalrate ?? '0') }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm d-none">
                    <label for="total">Total </label>
                    <input type="text" class="form-control" name="total" id="total" value="{{ old('total', $entry->total ?? '0') }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="discount">Numero da Factura <b class="text-danger"> *</b> </label>
                    <input type="hidden" class="form-control" name="discount" id="discount" value="{{ old('discount', $entry->discount ?? '0') }}" readonly="readonly"  />                
                    <input type="text" class="form-control" name="number" id="number" value="{{ old('number', $entry->number ?? '') }}" required=""  />                
                </div>

                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>                    
                    <a href="{{ route('cancel.entries') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> cancelar</i>
                    </a> &nbsp;
                </div>
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>                    
                    <button type="submit" class="btn btn-primary pull-right form-control">
                        <i class="fa fa-check-circle"> finalizar</i>
                    </button>
                </div>
            </div>
        </div>
    </form> 
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Actualizar produtos retalho</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="modalBody">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
    
<script>
    function getData(id, operation, searchBy, quantity) {
        var url = '{{ route("api.entry.add") }}';
        if (parseFloat(quantity) <= 0 || parseInt(quantity) === undefined || quantity === '') {
            bootbox.alert('Informe a quantidade');
            return;
        }
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, operation: operation, searchBy: searchBy, quantity: quantity},
            success: function (data) {
                fillData(data);
            }
        });
    }

    function insertEntry() {
        var operation = 11;
        var searchBy = "id";
        var url = '{{ route("api.entry.add") }}';
        var product_id = $('#product_id').val();
        var name = $('#name').val();
        var buying_price = $('#buying_price').val();
        var old_price = $('#old_price').val();
        var current_price = $('#current_price').val();
        var store_id = $('#store_id').val();
        var server_id = $('#server_id').val();
        var quantity = $('#quantity').val();
        var rate = $('#rate').val();

        $.ajax({
            'type': 'GET',
            'url': url,
            data: {name: name, rate: rate, server_id: server_id, operation: operation, id: product_id, current_price: current_price, buying_price: buying_price, searchBy: searchBy, old_price: old_price, store_id: store_id, quantity: quantity},
            success: function (data) {
                fillData(data);
                clear();
                location.reload();
            }
        });
    }

    function fillData(data) {
        var entries = JSON.parse(data);
        if (entries.length !== 0) {
            $('#tbody').html('');
        } else {
            $('#tbody').html('<tr><td class="text-center" colspan="6"> Sem registo ...</td></tr>');
        }
        var subtotal = 0, totalrate = 0, total = 0, discount = parseFloat($('#discount').val());
        entries.forEach((entry) => {
            var price = entry.buying_price / 1.16;
            sub = parseFloat(entry.quantity) * parseFloat(price);
            subtotal += sub;
            totalrate = subtotal * 0.16;
            //discount += (subtotal * parseFloat(entry.rate) / 100);
            total = subtotal + totalrate;
            searchBy = "id";
            id = entry.product_id;
            var tr = '<tr>';
            tr += '<td>';
            tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + entry.product_id + ', 1, ' + searchBy + ',1);"><i class="fa fa-arrow-up text-success"></i></button> ';
            if (parseFloat(entry.quantity) > 1) {
                tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + entry.product_id + ', -1, ' + searchBy + ',1);"><i class="fa fa-arrow-down text-danger"></i></button> ';
            }
            tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + entry.product_id + ', 0, ' + searchBy + ',1); location.reload();"><i class="fa fa-times-circle text-danger"></i></button> ';
            tr += `<button type="button" class="btn btn-group-sm" onclick="getChildren(${entry.product_id});"><i class="fa fa-users text-primary"></i></button> `;
            tr += '</td>';
            tr += '<td>';
            tr += '<input style="max-width:50px" value="' + entry.quantity + '" id="' + id + '" type="text" onblur="changeData(this.value,' + entry.product_id + ')"  />';
            +'); "';
            tr += '</td>';
            tr += '<td>' + entry.description + '</td>';
            tr += '<td class="text-right">' + price.toFixed(2) + '</td>';
          //  tr += '<td class="text-right">' + entry.rate + '</td>';
            tr += '<td class="text-right">' + sub.toFixed(2) + '</td>';
            tr += '</tr>';
            if (subtotal !== 0) {
                $('#tbody').append(tr);
            }
        });
        $('#subtotal').val(subtotal.toFixed(2));
        $('#totalrate').val(totalrate.toFixed(2));
        $('#discount').val(discount.toFixed(2));
        $('#total').val(total.toFixed(2));
    }
    document.addEventListener('DOMContentLoaded', function(){
        getData(0, 1, 'id');
  
        $('#addEntry').on('click', function () {
            var current_price = $('#current_price').val();
            var buying_price = $('#buying_price').val();
            if (current_price === "" || current_price <= 0) {
                bootbox.alert('Informe o preço de actual.');
                return;
            }
            if (buying_price === "" || buying_price <= 0) {
                bootbox.alert('Informe o preço de compra.');
                return;
            }
            insertEntry();
        });

        $("#barcode").on('keyup', function () {
            var id = this.value;
            getProduct(id, 'barcode');
        });

        $("#othercode").on('keyup', function () {
            var id = this.value;
            getProduct(id, 'othercode');
        });
        $('#profit').on('keyup', function () {
            var price = $('#buying_price').val();
            price = (price !== '' || price === undefined ? parseFloat(price) : 0);
            var profit = this.value;
            profit = (profit !== '' || profit === undefined ? parseFloat(profit) : 0);
    //        $('#current_price').attr('readonly', 'readonly');
            $('#current_price').val(((price * profit) / 100) + price);
        });

        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete.all') }}",
            select: function (event, ui) {
                getProduct(ui.item.id, 'id');
                $('#search').val('');
                return false;
            }
        });

        $('#checkNome').on('change', function () {
            var value = this.checked;
            if (value) {
                $("#name").removeClass("disabled");

            } else {
                $("#name").addClass("disabled");
            }
            console.log("Valor: " + value);
        });
        $('#currency_id').on('change', function () {
            var id = this.value;
            var url = '{{ route("api.get.exchange") }}';
            if (id === 'MT') {
                $('#exchange').val('1');
                doExchange();

            } else {
                $.ajax({
                    'type': 'GET',
                    'url': url,
                    data: {id: id},
                    success: function (data) {
                        exchange = JSON.parse(data);
                        $('#exchange').val(exchange.amount);
                        doExchange();

                    }
                });
            }
        });
    });
    function getProduct(id, searchBy) {
        var url = '{{ route("api.get.product") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, searchBy: searchBy},
            success: function (data) {
                product = JSON.parse(data);
                if (product !== null) {
                    $('#name').val(product.name);
                    $('#old_price').val(product.price);
                    $('#current_price').val(product.price);
                    $('#buying_price_before').val(product.buying);
                    $('#buying_price').val(product.buying);
                    $('#rate').val(product.rate);
                    $('#product_id').val(product.id);
                    $('#stock').val(product.description);
                } else {
                    clear();
                }

            }
        });
    }
    function clear() {
        $('#name').val('');
        $('#old_price').val('');
        $('#buying_price').val('');
        $('#current_price').val('');
        $('#rate').val('');
        $('#product_id').val('');
        $('#stock').val('');
        $('#quantity').val('');
        $('#buying_price_before').val('');
    }
    function changeData(v, id) {
        getData(id, 99, 'id', v);
    }
    
    function doExchange() {
        var buying_price_before = $('#buying_price_before').val();
        var exchange = $('#exchange').val();
        $('#buying_price').val(buying_price_before * exchange);
    }

    function getChildren(id) {
        $('#modalBody').html('');
        var url = '{{ route("product.children", ":id") }}';
        url = url.replace(":id", id);
        $.ajax({
            'type': 'GET',
            'url': url,
            success: function (data) {

                $('#modalBody').html(data);

            }
        });
        $("#myModal").modal();
    }

    function updateChildren() {
        var url = '{{ route("product.children.update") }}';
        let data =  $("form[name='childrenData']").serialize();
        $.ajax({
            'type': 'GET',
            'url': url,
            data: data,
            success: function (data) {
                $('#result').html(data);
            },
            error: function(error){
                $('#result').html(error);

            }
        });
        // $("#myModal").modal('hide');
    }

</script>

@endsection
