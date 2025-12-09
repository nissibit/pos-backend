<style>
    input[readonly="readonly"]{
        font-weight: bold;        
        color: black;
    }
</style>
<div class="card-header">
    <div class="row">
        @php
        $account = $account ?? null;
        $item = session('item');
        @endphp
        <div class="form-group input-group-sm col-sm ui-widget">
            <label for="name">@lang('messages.sale.customer_id') <i class="fa fa-search"></i> </label>
            <input type="search_customer" class="form-control" name="search_customer" id="search_customer"  />                
        </div>
        <div class="form-group input-group-sm col-sm">
            <label for="customer_name"><i class="fa fa-customer_name"></i> @lang('messages.sale.customer_name')</label>
            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" id="customer_name" value="{{ $item->customer_name ?? $account->accountable->fullname ?? '' }}" onkeyup="setCustomerDetails()" onchange="setCustomerDetails()" />                
            @error('customer_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group input-group-sm col-sm">
            <label for="customer_nuit"><i class="fa fa-customer_nuit"></i> @lang('messages.sale.customer_nuit')</label>
            <input type="text" class="form-control @error('customer_nuit') is-invalid @enderror" name="customer_nuit" id="customer_nuit" value="{{ $item->customer_nuit ?? $account->accountable->nuit ?? '' }}"  onkeyup="setCustomerDetails()" onchange="setCustomerDetails()" />                
            @error('customer_nuit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group input-group-sm col-sm">
            <label for="customer_address"><i class="fa fa-customer_address"></i> @lang('messages.sale.customer_address')</label>
            <input type="text" class="form-control @error('customer_address') is-invalid @enderror" name="customer_address" id="customer_address" value="{{  $item->customer_address ?? $account->accountable->address ?? '' }}" />                
            @error('customer_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group input-group-sm col-sm">
            <label for="customer_phone"><i class="fa fa-customer_phone"></i> @lang('messages.sale.customer_phone')</label>
            <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{ $item->customer_phone ?? $account->accountable->phone_nr ?? '' }}" />                
        </div>
        <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="{{ $item->customer_id ?? '' }}" />                
    </div>
</div>
<div class="card-header">
    <div class="row">
        <div class="form-group input-group-sm col-sm ui-widget">
            <label for="name">@lang('messages.button.search') <i class="fa fa-search"></i> </label>
            <input type="search" class="form-control" name="search" id="search" value="{{ old('search', $item->name ?? '') }}"   />                
        </div>

        <div class="form-group input-group-sm col-sm">
            <label for="othercode">@lang('messages.product.othercode') </label>
            <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $item->othercode ?? '') }}" />                
        </div>                
        <div class="form-group input-group-sm col-sm">
            <label for="name">@lang('messages.item.product') </label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"  readonly="readonly" />                            
        </div>
        <div class="form-group input-group-sm col-sm">
            <label for="stock"><i class="fa fa-stock"></i>@lang('messages.item.stock')</label>
            <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock', $item->stock ?? '') }}" readonly="readonly" />                
        </div>

    </div>
</div>
<div class="card-body">
    <table class="table table-bordered table-hover table-sm table-responsive-sm">
        <thead>
            <tr>
                <th style="max-widh: 10px;">@lang('messages.item.delete')</th>
                <th>@lang('messages.item.product')</th>
                <th>@lang('messages.item.quantity')</th>
                <th>@lang('messages.item.unitprice')</th>
                <th>@lang('messages.item.total')</th>
            </tr>
        </thead>
        <tbody id="tbody">               
        </tbody>

    </table>
</div>
<div class="card-footer">
    <div class="row">
        <div class="form-group col-sm">
            <label for="subtotal">@lang('messages.item.subtotal') </label>
            <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ old('subtotal', $item->subtotal ?? '0') }}" readonly="readonly" />                
        </div>
        <div class="form-group col row">
            <div class="form-group col-sm-6">
                <label for="discount">@lang('messages.item.discount') </label>
                <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', $item->discount ?? '0') }}"   />                
            </div>
            <div class="form-group col-sm-6">
                <label for="discountp">@lang('messages.item.discount_p')</label>
                <input type="text" class="form-control" name="discountp" id="discountp" value="{{ old('discountp', $item->discountp ?? '0') }}"   />                
            </div>
        </div>
        <div class="form-group col-sm">
            <label for="subtotal">@lang('messages.item.subtotal_2')</label>
            <input type="text" class="form-control" name="subtotal2" id="subtotal2" value="{{ old('subtotal2', $item->subtotal2 ?? '0') }}" readonly="readonly" />                
        </div>
        <div class="form-group col-sm">
            <label for="totalrate">@lang('messages.item.totalrate')</label>
            <input type="text" class="form-control" name="totalrate" id="totalrate" value="{{ old('totalrate', $item->totalrate ?? '0') }}"  readonly="readonly" />                
        </div>
        <div class="form-group col-sm">
            <label for="total">@lang('messages.item.total') </label>
            <input type="text" class="form-control" name="total" id="total" value="{{ old('total', $item->total ?? '0') }}"  readonly="readonly" />                
        </div>

    </div>
    <div class="row">
        <div class="form-group col-sm">
            <label for="total">@lang('messages.item.extenso') </label>
            <input type="text" class="form-control" name="extenso" id="extenso" value="{{ old('extenso', $item->extenso ?? '0') }}"  readonly="readonly" />                
        </div>
    </div>
    <!--Incluir a parte de pagamento-->
    @include('layouts.payment_direct')
    <!-- FIM Incluir a parte de pagamento-->

    <input type="hidden" name="qtdItems" id="qtdItems"  />
    <div class="row">
        <div class="col-sm btn-group-sm ">
            <label for="total">&nbsp; </label>
            <button type="submit" class="btn btn-success pull-right form-control">
                <i class="fa fa-check-circle"> @lang('messages.prompt.finish')</i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm btn-group-sm ">
            <label for="total">&nbsp;</label>
            <a href="{{ route('cancel.items') }}" class="btn btn-danger pull-right form-control">
                <i class="fa fa-times-circle"> @lang('messages.prompt.cancel')</i>
            </a>
        </div>
    </div>
</div>

<script>
    function getData(id, operation, searchBy, quantity) {
        var url = '{{ route("product.item.add") }}';
        if (parseFloat(quantity) <= 0 || parseInt(quantity) === undefined || quantity === '') {
            bootbox.alert('Informe a quantidade');
            return;
        }
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, operation: operation, searchBy: searchBy, quantity: quantity},
            'session': 'store',
            success: function (data) {
                var qtdItem = 0;
                var items = JSON.parse(data);
                var subtotal = 0, totalrate = 0, total = 0, discount = parseFloat(document.getElementById('discount').value);
                if (items.length !== 0) {
                    $('#tbody').html('');
                } else {
                    $('#tbody').html('<tr><td class="text-center" colspan="6"> Sem registo ...</td></tr>');
                }
//                items.forEach((item) => {                
                for (var i = 0; i < items.length; i++) {
                    item = items[i];
                    subtotal += item.subtotal;
                    subtotal -= discount;
//                    subtotal += item.subtotal;
                    totalrate = 0;
                    total = subtotal + totalrate;
                    var searchBy = "id";

                    var tr = '<tr>';
                    tr += '<td class="text-center">';
                    tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + item.product_id + ', 1, ' + searchBy + ');"><i class="fa fa-arrow-up text-success"></i></button> ';
                    tr += '<button type="button" class="btn-group-sm" onclick="getData(' + item.product_id + ', 0, ' + searchBy + ');"><i class="fa fa-times-circle text-danger"></i></button> ';
                    if (parseFloat(item.quantity) > 0.01) {
                        tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + item.product_id + ', -1, ' + searchBy + ');"><i class="fa fa-arrow-down text-danger"></i></button> ';
                    }
                    tr += '</td>';
                    tr += '<td>' + item.name + '</td>';
                    tr += '<td>';
                    tr += '<input style="max-width:50px" value="' + item.quantity + '" id="' + id + '" type="text" onblur="changeData(this.value,' + item.product_id + ')"  />';
                    +'); "';
                    tr += '</td>';
                    tr += '<td class="text-right">' + item.unitprice.toFixed(2) + '</td>';
                    var v = parseFloat(item.subtotal);
                    tr += '<td class="text-right">' + v.toFixed(2) + '</td>';
                    tr += '</tr>';
                    if (v > 0) {
                        $('#tbody').append(tr);
                        qtdItem++;
                    }
                }
                $('#QtdItems').html(": " + qtdItem);
                $('#qtdItems').val(qtdItem);
                $('#subtotal').val(subtotal.toFixed(2));
                $('#totalrate').val(totalrate.toFixed(2));
                $('#discount').val(discount.toFixed(2));
                $('#total').val(total.toFixed(2));
                calExtenso(total);

            }
        });
    }
    function calExtenso(total) {
        extenso(document.getElementById('total').value, 'extenso');
    }

    function changeData(v, id) {
        getData(id, 99, 'id', v);
    }

    function getLastProductadded() {
        var url = '{{ route("product.get.last.added") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            success: function (data) {
                product = JSON.parse(data);
                if (product !== null) {
                    $('#name').val(product.name);
                    $('#stock').val(product.description);
                } else {
                    $('#name').val('');
                }

            }
        });
    }
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
                    $('#stock').val(product.description);
                } else {
                    $('#name').val('');
                }

            }
        });
    }
    \
    document.addEventListener('DOMContentLoaded', function () {
        $('#search').val('');
        getData(0, 1, 'id', 1);
        getLastProductadded();

        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                getData(ui.item.id, 99, 'id', 1);
                $('#search').val('');
                $('#search').focus();
                location.reload();
                return false;
            }
        });
        $("#search_customer").autocomplete({
            source: "{{ route('customer.autocomplete') }}",
            select: function (event, ui) {
                $('#customer_name').val(ui.item.name);
                $('#customer_phone').val(ui.item.phone_nr);
                $('#customer_id').val(ui.item.id);
                $('#customer_nuit').val(ui.item.nuit);
                $('#customer_address').val(ui.item.address);
                $('#search').val('');
                return false;
            }
        });

        $('#discount').on('keyup', function () {
            var discount = parseFloat(this.value);
            var topay = parseFloat($('#subtotal').val());    
            var total = (topay - discount);
            var discountp = discount / (topay ) * 100;
            $('#total').val(Math.round(total));
            $('#discountp').val(discountp.toFixed(2));
            calExtenso(total);
        });
        $('#discountp').on('keyup', function () {
            var discountp = this.value;
            var topay = parseFloat($('#subtotal').val());
            var discount = (discountp * topay / 100);
            $('#discount').val(Math.round(discount).toFixed(2));
            var total = (topay - discount);
            $('#total').val(Math.round(total));
            calExtenso(total);
        });
    });
    function setCustomerDetails() {
        var name = $("#customer_name").val();
        var phone = $('#customer_phone').val();
        var customer_id = $('#customer_id').val();
        var nuit = $('#customer_nuit').val();
        var address = $('#customer_address').val();
        var url = '{{ route("api.customer.details") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {customer_name: name, customer_nuit: nuit, customer_address: address, customer_phone: phone, customer_id: customer_id},
            success: function (data) {
                console.log("Data of customer saved" + data);
            }
        });
    }
</script>
