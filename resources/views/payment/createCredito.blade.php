@extends('payment.indexPayment')
@section('content-payment')
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('payment.store') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm"><h1><i class="fa fa-book-open"> </i> VD <strong class="text-danger">{{ str_pad($factura->id, 4, '0', 0) }} </strong></h1></div>
            <div class="col-sm text-right"><h1><strong>{{ number_format($factura->total ?? 0, 2) }}</strong></h1></div>
        </div>
        <div class="card-header">
            <dl class="dl-vertical">
                <dt>Nome do Cliente</dt>
                <dd>{{ $factura->customer_name }}</dd>
                <input type="hidden" name="factura" value="{{ $factura->id }}"  />
                <input type="hidden" name="day" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" />
                <dt>Contacto do Cliente</dt>
                <dd>{{ $factura->customer_phone }}</dd>          
                <dt>Data</dt> 
                <dd>{{ $factura->day->format('d-m-Y') }}</dd>           
            </dl>
        </div>
        <div class="card-header">
            <div class="row">  
                <div class="col-sm form-group input-group-sm">
                    <label for="way" class="control-label">Meio <b class="text-danger">*</b></label>
                    <select class="form-control @error('way') is-invalid @enderror" name="way" id="way">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach(\App\Base::meioPagamento() ?? array() as $way)
                        <option value="{{ $way }}" {{ old('way',  $payment->way ?? 'Cash') == $way ? 'selected' : '' }}>  {{ $way }}</option>                    
                        @endforeach
                    </select>
                    @error('way')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <div class="form-group input-group-sm col-sm">
                    <label for="reference"><i class="fa fa-reference"></i> Referencia</label>
                    <input type="text" class="form-control" name="reference" id="reference" value="{{ old('reference', $item->reference ?? '') }}" />                
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
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Valor <i class="fa fa-amount"></i> </label>
                    <input type="amount" class="form-control" name="amount" id="amount" value="{{ old('amount', $item->amount ?? '') }}" onkeyup="exchanged.value = this.value;"    />                
                </div>

                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">Valor Cambiado <i class="fa fa-exchanged"></i> </label>
                    <input type="exchanged" class="form-control" name="exchanged" id="exchanged" value="{{ old('exchanged', $item->exchanged ?? '') }}" readonly="readonly"  />                
                </div>
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">  &nbsp; </label><br />
                    <button type="button" class="btn btn-primary btn-group-sm" id="addPayment" onclick="getData(way.value, 1);">
                        <i class="fa fa-check-circlw"> pagar</i>
                    </button>
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>Meio</th>
                        <th>Referencia</th>
                        <th>Moeda</th>
                        <th>Total (MT)</th>
                    </tr>
                </thead>
                <tbody id="tbody">               
                </tbody>

            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="form-group col-sm">
                    <label for="totalrate">A pagar </label>
                    <input type="text" class="form-control" name="topay" id="topay" value="{{ $factura->total }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="total">Recebido </label>
                    <input type="text" class="form-control" name="total" id="total" value="{{ old('total', $item->total ?? '0') }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="discount">Desconto </label>
                    <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', $item->discount ?? '0') }}"  />                
                </div>
                <div class="form-group col-sm">
                    <label for="change">Troco </label>
                    <input type="text" class="form-control" name="change" id="change" value="{{ old('change', $item->change ?? '0') }}"  readonly="readonly" />                
                </div>

            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp; </label>
                    <button type="button" class="btn btn-success pull-right form-control"  onclick="submitForm(this);">
                        <i class="fa fa-check-circle"> finalizar</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>
                    <a href="{{ route('payment.cancel') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> cancelar</i>
                    </a>
                </div>
            </div>
        </div>
    </form> 
</div>
<script>
    function getData(way, operation) {
        var url = '{{ route("api.payment.add") }}';
        var reference = $('#reference').val();
        var amount = $('#amount').val();
        var exchanged = $('#exchanged').val();
        var currency_id = $('#currency_id').val();
        if (way === '') {
            bootbox.alert('Seleccione o meio de pagamento.');
            return;
        }
        if (parseFloat(amount) <= 0) {
            bootbox.alert('Informe o valor.');
            return;
        }
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {way: way, amount: amount, reference: reference, exchanged: exchanged, currency_id: currency_id, operation: operation},
            success: function (data) {
                var items = JSON.parse(data);
                var recebido = 0;
                var troco = 0;
                var topay = parseFloat($('#topay').val());
                var desconto;

                if (items.length !== 0) {
                    $('#tbody').html('');
                } else {
                    $('#tbody').html('<tr><td class="text-center" colspan="5"> Sem registo ...</td></tr>');
                }
                items.forEach((item) => {
                    if (item.way !== -1) {
                        desconto = parseFloat($('#discount').val());
                        var v = parseFloat(item.exchanged);
                        recebido += v;
                        var operation = 0;
                        var way1 = item.way;
                        var tr = '<tr>';
                        tr += '<td>';
                        tr += '<button type="button" class="btn btn-group-sm" onclick="getData(\'' + way1 + '\',' + operation + ');"><i class="fa fa-times-circle text-danger"></i></button> ';
                        tr += '</td>';
                        tr += '<td>' + item.way + '</td>';
                        tr += '<td>' + (item.reference !== null ? item.reference : " ") + '</td>';
                        tr += '<td>' + item.currency_id + '</td>';
                        tr += '<td class="text-right">' + v.toFixed(2) + '</td>';
                        tr += '</tr>';

                        $('#tbody').append(tr);
                    }
                });
                $('#total').val(recebido.toFixed(2));
                $('#change').val((recebido - desconto - topay).toFixed(2));


            }
        });
    }

    document.addEventListener('DOMContentLoaded', function(){
        $('#amount').focus();
        getData(99, 0);
        $('#discount').on('keyup', function () {
            var discount = parseFloat(this.value);
            var topay = parseFloat($('#topay').val());
            var total = parseFloat($('#total').val());
            var change = total - (topay - discount);
            console.log("A pagar: " + topay + ", ");
            console.log("Desconto: " + discount + ", ");
            console.log("Recebido: " + total);
            $('#change').val(change);
        });
    });

    function submitForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form    
        btn.form.submit();
    }
</script>
@endsection
