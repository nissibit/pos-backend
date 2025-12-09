<div class=" bg-white">
    <h2>Pagamento</h2>
    <div class="row">  
        <div class="col-sm form-group input-group-sm">
            <label for="way" class="control-label">@lang('messages.payment.way') <b class="text-danger">*</b></label>
            <select class="form-control @error('way') is-invalid @enderror setItem" name="way" id="way">
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
            <input type="text" class="form-control setItem" name="reference" id="reference" value="{{ old('reference', $item->reference ?? '') }}" />                
        </div>
        <div class="col-sm form-group input-group-sm">
            <label for="currency_id" class="control-label">@lang('messages.entity.currency') <b class="text-danger">*</b></label>
            <select class="form-control @error('currency_id') is-invalid @enderror setItem" name="currency_id" id="currency_id">
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
            <input type="exchange" class="form-control setItem" name="exchange" id="exchange" value="{{ old('exchange', $item->exchange ?? '1') }}"  readonly="readonly"   />                
        </div>
        <div class="form-group input-group-sm col-sm ui-widget">
            <label for="name">@lang('messages.payment.amount') <i class="fa fa-amount"></i> </label>
            <input type="amount" class="form-control setItem" name="amount" id="amount" value="{{ old('amount', $item->amount ?? '') }}" onkeyup="doExchange();"    />                
        </div>

        <div class="form-group input-group-sm col-sm ui-widget">
            <label for="name">@lang('messages.payment.amount_mzn') <i class="fa fa-exchanged"></i> </label>
            <input type="exchanged" class="form-control setItem" name="exchanged" id="exchanged" value="{{ old('exchanged', $item->exchanged ?? '') }}" readonly="readonly"  />                
        </div>    

    </div>
</div>