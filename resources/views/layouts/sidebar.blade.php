<div class="w3-bar-block w3-white w3-round-large w3-margin-top w3-display-container w3-topbar w3-bottombar w3-border-theme" style="height: 90vh;">
    <a href="{{ route('home') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'home' ? 'w3-theme' : '' }}"><i class="fas fa-home"></i> @lang('messages.sidebar.home')</a>
    <a href="{{ route('products.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'products' ? 'w3-theme' : '' }}"><i class="fas fa-cube"></i> @lang('messages.sidebar.product')</a>
    <a href="{{ route('facturas.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'facturas' ? 'w3-theme' : '' }}"><i class="fas fa-shopping-cart"></i> @lang('messages.sidebar.sale')</a>
    <!-- <a href="{{ route('payments.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'payments' ? 'w3-theme' : '' }}"><i class="fas fa-dollar-sign"></i> @lang('messages.sidebar.payment')</a> -->
    
    <div class="w3-bar-item w3-display-bottommiddle w3-round-large w3-border-top w3-border-theme ">
        <div class="w3-flex" style="align-items: center; justify-content: space-between;">
            <form method="POST" action="{{ route('home') }}">
                @csrf
                <x-button onclick="event.preventDefault();this.closest('form').submit();">
                    <i class="fas fa-power-off"></i> sair
                </x-button>

            </form>
            <x-button onclick="alert('brevemente...');">
                <i class="fas fa-cog"></i>
            </x-button>
        </div>
    </div>
</div>