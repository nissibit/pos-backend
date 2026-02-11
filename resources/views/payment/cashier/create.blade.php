<div>
    <x-simple-card message="Abertura de caixa"></x-simple-card>
    <div>
        <x-auth-validation-errors></x-auth-validation-errors>
        <div id="alert-cashier-create"></div>
    </div>
    <div class="w3-card-2">
        <form role="form" autocomplete="off" class="w3-grid-padding w3-padding" method="post" id="form_cashier_create">
            @csrf
            <x-label :value="__('messages.cashier.initial') .'(MT)'" />
            <x-input type="text" name="initial" id="initial" value="{{ old('initial', $cashier->initial ?? '0') }}" />
            <div>
                @error('initial')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="w3-right-align">
                <x-action-button type="button" id="btnSaveCashier">
                    <i class="fa fa-check-circle"></i> finalizar
                </x-action-button>
            </div>
        </form>
    </div>
</div>