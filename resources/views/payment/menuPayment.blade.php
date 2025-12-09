<div class="row">
    <div class="form-group col btn-group-sm">        
        @can("pesquisa_payment")
        <a href="{{ route('payment.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> @lang('messages.payment.payments')</i>
        </a>        
        @endcan
        <a href="{{ route('payment.credit.search') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> @lang('messages.payment.credits')</i>
        </a>
        @can("list_cashier")
        <a href="{{ route('cashier.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> @lang('messages.payment.cashiers')</i>
        </a>
        @endcan
        @if($open == 0)
        <a href="{{ route('cashier.create') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-folder-open">  @lang('messages.payment.cashier_open')</i>
        </a>
        @else
        <a href="{{ route('cashflow.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> @lang('messages.entity.cashflow')</i>
        </a>
        <a href="{{ route('cashflow.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> @lang('messages.entity.cashflow')</i>
        </a>
        @can("close_cashier")
        <a href="{{ route('cashier.edit', $cashier->id ?? 0) }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-check-circle">  @lang('messages.payment.cashier_close')</i>
        </a>
        @endcan
        @endif
    </div>

    <div class="form-group col input-group-sm">
        <form id="payment_search" role="form" autocomplete="off" action="{{ route('payment.search') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="{{ __('messages.prompt.search') }}" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
