<div class="w3-flex" style="grid-template-columns: auto 150px;">
    <div class="w3-flex" style="gap: 8px;">
        <div class="w3-dropdown-hover">
            <x-button>
                <i class="fas fa-dollar-sign"></i>
                @lang('messages.entity.factura')
            </x-button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" onclick="loadingInvoiceForPayment(false)" class="w3-bar-item w3-button"><i class="fas fa-list"></i> Não pagas</a>
                <a href="#" onclick="loadingInvoiceForPayment(true)" class="w3-bar-item w3-button"><i class="fas fa-check"></i> Pagas</a>
            </div>
        </div>
        <div class="w3-dropdown-hover">
            <x-button>
                <i class="fas fa-dollar-sign"></i>
                @lang('messages.entity.payment')
            </x-button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="{{ route('payment.index') }}" class="w3-bar-item w3-button"><i class="fas fa-search"></i> @lang('messages.payment.payments')</a>
                <a href="{{ route('payment.credit.search') }}" class="w3-bar-item w3-button"><i class="fas fa-list"></i> @lang('messages.payment.credits')</a>
            </div>
        </div>

        <div class="w3-dropdown-hover">
            <x-button>
                <i class="fas fa-dollar-sign"></i>
                @lang('messages.entity.cashflow')
            </x-button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="{{ route('cashflow.index') }}" class="w3-bar-item w3-button"><i class="fas fa-list"></i> @lang('messages.button.list')</a>
                <a href="{{ route('cashflow.create') }}" class="w3-bar-item w3-button"><i class="fas fa-plus-circle"></i> @lang('messages.button.new')</a>
            </div>
        </div>


        <div class="w3-dropdown-hover">
            <x-button>
                <i class="fas fa-dollar-sign"></i>
                @lang('messages.entity.cashier')
            </x-button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="{{ route('cashier.index') }}" class="w3-bar-item w3-button"><i class="fas fa-list"></i> @lang('messages.button.list')</a>
                <a href="{{ route('cashier.create') }}" class="w3-bar-item w3-button"><i class="fas fa-plus-circle"></i> @lang('messages.button.new')</a>
            </div>
        </div>
    </div>
</div>