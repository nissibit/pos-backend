@extends('creditnote.indexCreditNote')
@section('content-creditnote')
<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
    }
</style>
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('creditnote.store') }}">
        {{ csrf_field() }}
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3><i class="fa fa-book-open"> </i> Nota de Crédito para : <strong>{{ $payment->payment->acccountable->fullname ?? $payment->payment->customer_name ?? 'N/A' }}</strong></h3>
                    <input type="hidden" name="payment_id" id="payment_id" value="{{ $payment->id }}" />
                </div>
                <div class="col-sm-3 text-right">
                    <h2 id="QtdItems"></h2>
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
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="form-group col-sm">
                    <label for="subtotal">SubTotal </label>
                    <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ old('subtotal', $item->subtotal ?? '0') }}" readonly="readonly" />                
                </div>
                <div class="form-group col row d-none">
                    <div class="form-group col-sm-6">
                        <label for="discount">Desc. Valor </label>
                        <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', $item->discount ?? '0') }}"   />                
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="discountp">Desc. % </label>
                        <input type="text" class="form-control" name="discountp" id="discountp" value="{{ old('discountp', $item->discountp ?? '0') }}"   />                
                    </div>
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
            <div class="row">
                <div class="form-group col-sm">
                    <label for="total">Extenso </label>
                    <input type="text" class="form-control" name="extenso" id="extenso" value="{{ old('extenso', $item->extenso ?? '0') }}"  readonly="readonly" />                
                </div>
            </div>
            <!--Reason-->
            <div class="row">
                <div class="col-sm form-group input-group-sm">
                    <label for="reason" class="control-label">Motivo <b class="text-danger">*</b></label>
                    <select class="form-control @error('reason') is-invalid @enderror" name="reason" id="reason">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach(\App\Base::reasonCreditNote() ?? array() as $reason)
                        <option value="{{ $reason }}" {{ old('reason',  $creditnote->reason ?? 'Cash') == $reason ? 'selected' : '' }}>  {{ $reason }}</option>                    
                        @endforeach
                    </select>
                    @error('reason')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm form-group input-group-sm">
                    <label for="return_money" class="control-label">Reenbolsar valor <b class="text-danger">*</b></label>
                    <select class="form-control @error('return_money') is-invalid @enderror" name="return_money" id="return_money">
                        <option value=""> ----- Selecciona ----- </option>
                        <option value="NAO" {{ old('return_money', $creditnote->return_money ?? '')=='NAO' ? 'selected' : '' }}>NAO</option>
                        <option value="SIM" {{ old('return_money',  $creditnote->return_money ?? '')=='NAO' ? 'selected' : '' }}>SIM</option>                        
                    </select>
                    @error('return_money')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm form-group input-group-sm">
                    <label for="return_stock" class="control-label">Devolver STOCK <b class="text-danger">*</b></label>
                    <select class="form-control @error('return_stock') is-invalid @enderror" name="return_stock" id="return_stock">
                        <option value=""> ----- Selecciona ----- </option>
                        <option value="NAO" {{ old('return_stock', $creditnote->return_stock ?? '')=='NAO' ? 'selected' : '' }}>NAO</option>
                        <option value="SIM" {{ old('return_stock',  $creditnote->return_stock ?? '')=='NAO' ? 'selected' : '' }}>SIM</option>                        
                    </select>
                    @error('return_stock')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="description" class="control-label">Descrição</label>
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $company->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="qtdItems" id="qtdItems"  />
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp; </label>
                    <button type="submit" class="btn btn-success pull-right form-control">
                        <i class="fa fa-check-circle"> finalizar</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>
                    <a href="{{ route('cancel.items') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> cancelar</i>
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
                            subtotal += item.subtotal / 1.16;
                            //                    subtotal += item.subtotal;
                            totalrate = (subtotal * item.rate / 100);
                            total = subtotal + totalrate - discount;
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
                            var v = parseFloat(item.subtotal / 1.16);
                            tr += '<td class="text-right">' + v.toFixed(2) + '</td>';
                            tr += '</tr>';
                            if (v > 0) {
                                $('#tbody').append(tr);
                                qtdItem++;
                            }
                        }
                        $('#QtdItems').html("Artigos: " + qtdItem);
                        $('#qtdItems').val(qtdItem);
                        $('#subtotal').val(subtotal.toFixed(2));
                        $('#totalrate').val(totalrate.toFixed(2));
                        $('#discount').val(discount.toFixed(2));
                        $('#total').val(total.toFixed(2));
                        if (total > 0) {
                            $('#extenso').val(extensoNormal(total.toFixed(2)));
                        } else {
                            $('#extenso').val('');
                        }

                    }
                });
            }
            $(document).ready(function () {
                $('#search').val('');
                getData(0, 1, 'id', 1);
                getLastProductadded();

            });

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
            document.addEventListener('DOMContentLoaded', function(){ 
                window.onbeforeunload = function () {
                    localStorage.setItem('product', $('#name').val());
                    localStorage.setItem('stock', $('#stock').val());
                };
                window.onload = function () {
                    var name = localStorage.getItem('name');
                    if (name !== null) {
                        $("#name").val(name);
                    }
                    var stock = localStorage.getItem('stock');
                    if (stock !== null) {
                        $("#stock").val(stock);
                    }
                };
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

    </form>
</div>
@endsection
