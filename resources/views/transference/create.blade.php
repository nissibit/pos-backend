@extends('transference.indexTransference')
@section('content-transference')
<div class="card">
    <div class="card-header">
        <i class="fas fa-box"> Efectuar Transferência</i>
    </div>
    <form class="form-horizontal" method="POST" action="{{ route('transference.store') }}">
        {{ csrf_field() }}

        <!-- Adicionar produtos para Transferência  -->
        <div class="card-header">
            <div class="row">
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Procurar <i class="fa fa-search"></i> </label>
                    <input type="search" class="form-control" name="search" id="search" value="{{ old('search', $item->name ?? '') }}"   />                
                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="barcode"><i class="fa fa-barcode"></i> Cod. barras</label>
                    <input type="text" class="form-control" name="barcode" id="barcode" value="{{ old('barcode', $item->barcode ?? '') }}" />                
                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="othercode">Outro Codigo </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $item->othercode ?? '') }}" />                
                </div>                
                <div class="form-group input-group-sm col-sm">
                    <label for="name">Produto </label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"  readonly="readonly" />                
                </div>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th style="max-widh: 10px;">Apagar</th>
                        <th>Designacao</th>
                        <th>Qtd</th>
                        <th>Preco Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tbody">               
                </tbody>

            </table>
            <!-- / Adicionar produtos para Transferência  -->
            <div class="row input-group-sm">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="from" class="control-label">Armazem/Loja Origem<b class="text-danger">*</b></label>
                    <select class="form-control @error('from') is-invalid @enderror" name="from">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($stores ?? array() as $store)
                        <option value="{{ $store->id }}" {{ old('from', $transference->from ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                        @endforeach
                    </select>
                    @error('from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="to" class="control-label">Armazem/Loja Destino <b class="text-danger">*</b></label>
                    <select class="form-control @error('to') is-invalid @enderror" name="to">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($stores ?? array() as $store)
                        <option value="{{ $store->id }}" {{ old('to', $transference->to ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                        @endforeach
                    </select>
                    @error('to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col input-group-sm">
                    <label for="motive" class="control-label">Motivo <b class="text-danger">*</b></label>
                    <input type="text" class="form-control @error('motive') is-invalid @enderror" name="motive" id="motive" value="{{ old('motive', $transference->motive ?? '') }}"  />
                    <input type="hidden" class="form-control @error('day') is-invalid @enderror" name="day" id="day" value="{{ old('day', \Carbon\Carbon::today()->format('Y-m-d') ?? '') }}"  />                    
                    @error('motive')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"  >{{ old('description', $transference->description ?? '')  }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class=" row" style="display:none;">
                <div class="form-group col-sm">
                    <label for="subtotal">SubTotal </label>
                    <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ old('subtotal', $item->subtotal ?? '0') }}" readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="discount">Desconto </label>
                    <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', $item->discount ?? '0') }}" readonly="readonly"  />                
                </div>
                <div class="form-group col-sm">
                    <label for="totalrate">Total Imposto </label>
                    <input type="text" class="form-control" name="totalrate" id="totalrate" value="{{ old('totalrate', $item->totalrate ?? '0') }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="total">Total </label>
                    <input type="text" class="form-control" name="total" id="total" value="{{ old('total', $item->total ?? '0') }}"  readonly="readonly" />                
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-check-circle"> finalizar</i>
                    </button>
                </div>
            </div>
    </form>
</div>
</div>

<script>
    function getData(id, operation, searchBy, quantity) {
        var url = '{{ route("api.item.add") }}';
//        var quantity = $('#quantity').val();
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
                    subtotal += item.subtotal / 1.16;
                    totalrate = (subtotal * item.rate / 100);
                    total = subtotal + totalrate - discount;
                    var searchBy = "id";

                    var tr = '<tr>';
                    tr += '<td class="text-center">';
                    tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + item.product_id + ', 1, ' + searchBy + ');"><i class="fa fa-arrow-up text-success"></i></button> ';
                    tr += '<button type="button" class="btn-group-sm" onclick="getData(' + item.product_id + ', 0, ' + searchBy + ');"><i class="fa fa-times-circle text-danger"></i></button> ';
                    if (parseFloat(item.quantity) > 1) {
                        tr += '<button type="button" class="btn btn-group-sm" onclick="getData(' + item.product_id + ', -1, ' + searchBy + ');"><i class="fa fa-arrow-down text-danger"></i></button> ';
                    }
                    tr += '</td>';
                    tr += '<td>' + item.name + '</td>';
                    tr += '<td>';
                    tr += '<input style="max-width:50px" value="' + item.quantity + '" id="' + id + '" type="text" onblur="changeData(this.value,' + item.product_id + ')"  />';
                    +'); "';
                    tr += '</td>';
                    tr += '<td class="text-right">' + item.unitprice.toFixed(2) + '</td>';
                    var v = parseFloat(item.subtotal / 1.16);
                    tr += '<td class="text-right">' + v.toFixed(2) + '</td>';
                    tr += '</tr>';
                    if (v > 0) {
                        $('#tbody').append(tr);
                    }
                }
//                );
                $('#subtotal').val(subtotal.toFixed(2));
                $('#totalrate').val(totalrate.toFixed(2));
                $('#discount').val(discount.toFixed(2));
                $('#total').val(total.toFixed(2));

            }
        });
    }
    $(document).ready(function () {
        getData(0, 1, 'id');
    });
//99 is for add by any quantity
    $("#barcode").on('keyup', function () {
        var id = this.value;
        getData(id, 99, 'barcode');
        getProduct(id, 'barcode');
    });
    function changeData(v, id) {
        getData(id, 99, 'id', v);
    }

    $("#othercode").on('keyup', function () {
        var id = this.value;
        getData(id, 99, 'othercode');
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
                    $("#barcode").val('');
                } else {
                    $('#name').val('');
                }

            }
        });
    }
    document.addEventListener('DOMContentLoaded', function(){ 
        $('.qtd').on('keyup', function (obj) {
            console.log(obj);
        })
        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                getData(ui.item.id, 99, 'id', 1);
                $('#name').val(ui.item.name);
                $('#search').val('');
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
            var totalrate = topay * 0.16;
            var total = (topay + totalrate) - discount;
            var discountp = discount / total * 100;
            $('#total').val(Math.round(total));
            $('#discountp').val(discountp.toFixed(2));
        });
        $('#discountp').on('keyup', function () {
            var topay = parseFloat($('#subtotal').val());
            var discountp = this.value;
            var discount = (discountp * topay / 100);
            $('#discount').val(discount.toFixed(2));
            var totalrate = topay * 0.16;
            var total = (topay - discount);
            $('#totalrate').val((total * 0.16).toFixed(2));
            total += total * 0.16;
            $('#total').val(Math.round(total));

        });
    });
</script>
@endsection
