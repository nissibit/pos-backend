@extends('payment.indexPayment')
@section('content-payment')
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('payment.store') }}">
        {{ csrf_field() }}
        <div class="row p-2">
            <div class="col-sm"><h1><i class="fa fa-book-open"> </i> VD <strong class="text-danger">{{ str_pad($factura->id, 4, '0', 0) }} </strong></h1></div>
            <div class="col-sm text-right"><h1><strong>{{ number_format($factura->total ?? 0, 2) }}</strong></h1></div>
        </div>

        <div class="card-header">
            <div class="row">
                <div class="col-sm">
                    <dt>@lang('messages.sale.customer_id')</dt>
                    <dd>{{ $factura->customer_name ?? $factura->account->accountable->fullname ?? '' }}</dd>
                    <input type="hidden" name="factura" value="{{ $factura->id }}"  />
                    <input type="hidden" name="day" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" />
                </div>
                <div class="col-sm">
                    <dt>@lang('messages.sale.customer_phone')</dt>
                    <dd>{{ $factura->customer_phone ??  $factura->account->accountable->phone_nr ?? '' }}</dd>          
                </div>
                <div class="col">
                    <dt>@lang('messages.sale.day')</dt> 
                    <dd>{{ $factura->day->format('d-m-Y') }}</dd>           
                </div>
            </div>
        </div>
        <div class="card-header">
            <div class="row">  
                <input type="hidden" name="account" id="account" value="{{  $factura->account->id ?? '' }}" />
                <div class="col-sm form-group input-group-sm">
                    <label for="way" class="control-label">@lang('messages.payment.way') <b class="text-danger">*</b></label>
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
                    <label for="reference"><i class="fa fa-reference"></i> @lang('messages.payment.reference')</label>
                    <input type="text" class="form-control" name="reference" id="reference" value="{{ old('reference', $item->reference ?? '') }}" />                
                </div>
                <div class="col-sm form-group input-group-sm">
                    <label for="currency_id" class="control-label">@lang('messages.entity.currency') <b class="text-danger">*</b></label>
                    <select class="form-control @error('currency_id') is-invalid @enderror" name="currency_id" id="currency_id">
                        <option value="0">MT</option>
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
                <div class="form-group input-group-sm col-sm ui-widget d-none">
                    <label for="name">@lang('messages.entity.exchange') <i class="fa fa-exchange"></i> </label>                               
                    <input type="exchange" class="form-control" name="exchange" id="exchange" value="{{ old('exchange', $item->exchange ?? '1') }}"  readonly="readonly"   />                
                </div>
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">@lang('messages.payment.amount') <i class="fa fa-amount"></i> </label>
                    <input type="amount" class="form-control" name="amount" id="amount" value="{{ old('amount', $item->amount ?? '') }}" onkeyup="doExchange();"    />                
                </div>

                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">@lang('messages.payment.amount_mzn') <i class="fa fa-exchanged"></i> </label>
                    <input type="exchanged" class="form-control" name="exchanged" id="exchanged" value="{{ old('exchanged', $item->exchanged ?? '') }}" readonly="readonly"  />                
                </div>
                <div class="form-group input-group-sm col-sm ui-widget">
                    <label for="name">  &nbsp; </label><br />
                    <button type="button" class="btn btn-primary btn-group-sm" id="addPayment" onclick="addOne();">
                        <i class="fa fa-check-circlw"> @lang('messages.payment.pay')</i>
                    </button>
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('messages.payment.way')</th>
                        <th>@lang('messages.payment.reference')</th>
                        <th>@lang('messages.entity.currency')</th>
                        <th>@lang('messages.item.total') (MT)</th>
                    </tr>
                </thead>
                <tbody id="tbody">               
                </tbody>

            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="form-group col-sm">
                    <label for="totalrate">@lang('messages.payment.topay') </label>
                    <input type="text" class="form-control" name="topay" id="topay" value="{{ $factura->total }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="total">@lang('messages.payment.payed') </label>
                    <input type="text" class="form-control" name="total" id="total" value="{{ old('total', $item->total ?? '0') }}"  readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="discount">@lang('messages.payment.discount') </label>
                    <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', $item->discount ?? '0') }}" readonly="readonly" />                
                </div>
                <div class="form-group col-sm">
                    <label for="change">@lang('messages.payment.change') </label>
                    <input type="text" class="form-control" name="change" id="change" value="{{ old('change', $item->change ?? '0') }}"  readonly="readonly" />                
                </div>

            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp; </label>
                    <button type="button" class="btn btn-success pull-right form-control" onclick="submitForm(this);">
                        <i class="fa fa-check-circle"> @lang('messages.prompt.finish')</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>
                    <a href="{{ route('payment.cancel') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> @lang('messages.prompt.cancel')</i>
                    </a>
                </div>
            </div>
        </div>
    </form> 
</div>
<script>
    function addOne() {
        var way = $('#way').val();
        getData(way, 1);
        again();
    }
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
                    $('#tbody').html('<tr><td class="text-center" colspan="5"> '+ "{{ __('messages.prompt.no_records') }}" +'</td></tr>');
                }
                items.forEach((item) => {
                    if (item.way !== -1) {
                        desconto = parseFloat($('#discount').val());
                        var v = parseFloat(item.exchanged);
                        recebido += v;
                        var operation = -1;
                        var way1 = item.way;
                        var tr = '<tr>';
                        tr += '<td>';
                        tr += '<button type="button" class="btn btn-group-sm" onclick="getData(\'' + way1 + '\',-1); again();"><i class="fa fa-times-circle text-danger"></i></button> ';
                        tr += '</td>';
                        tr += '<td>' + item.way + '</td>';
                        tr += '<td>' + (item.reference !== null ? item.reference : " ") + '</td>';
                        tr += '<td>' + item.currency + '</td>';
                        tr += '<td class="text-right">' + number_format(v, 2) + '</td>';
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
//       again();
        getData(99, 99);

    });
    function again() {
        getData(99, 99);
        // location.reload();
    }
    document.addEventListener('DOMContentLoaded', function(){
        $('#amount').focus();
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

    $('#currency_id').on('change', function () {
        var id = this.value;
        var url = '{{ route("api.get.exchange") }}';
        if (id === '0') {
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

    function doExchange() {
        var amount = $('#amount').val();
        var exchange = $('#exchange').val();
        console.log(amount * exchange);
        $('#exchanged').val(amount * exchange);
    }
    function submitForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form    
        btn.form.submit();
    }
</script>
@endsection
