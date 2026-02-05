<div class="w3-bar-block w3-white w3-round-large w3-margin-top w3-display-container w3-topbar w3-bottombar w3-border-theme" style="height: 90vh;">
    <a href="{{ route('home') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'home' ? 'active' : '' }}"><i class="fas fa-home"></i> @lang('messages.sidebar.home')</a>
    @can('viewAny', [App\Models\Factura::class]) <a href="{{ route('factura.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'factura' ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> @lang('messages.sidebar.sale')</a> @endcan
    <a href="{{ route('payment.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'payment' ? 'active' : '' }}"><i class="fas fa-dollar-sign"></i> @lang('messages.sidebar.payment')</a>
    <a href="{{ route('fund.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'fund' ? 'active' : '' }}"><i class="fas fa-coins"></i> @lang('messages.sidebar.fund')</a>
    <a href="{{ route('creditnote.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'creditnote' ? 'active' : '' }}"><i class="fas fa-folder"></i> @lang('messages.sidebar.creditnote')</a>
    <a href="{{ route('output.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'output' ? 'active' : '' }}"><i class="fas fa-handshake"></i> @lang('messages.sidebar.output')</a>
    <a href="{{ route('quotation.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'quotation' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.sidebar.quotation')</a>
    <a href="{{ route('credit.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'credit' ? 'active' : '' }}"><i class="fas fa-coins"></i> @lang('messages.sidebar.credit')</a>
    <a href="#product" onclick="accordion('product')" class="w3-bar-item w3-button {{ ($active ?? '') == 'product' ? 'product' : '' }}"><i class="fas fa-cubes"></i> @lang('messages.sidebar.product')</a>
    <ul class="w3-hide" id="product">
        <a href="{{ route('product.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'product_index' ? 'active' : '' }}"><i class="fas fa-list"></i> @lang('messages.sidebar.records')</a>
        <a href="{{ route('category.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'category_index' ? 'active' : '' }}"><i class="fas fa-cube"></i> @lang('messages.entity.category')</a>
        <a href="{{ route('unity.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'unity_index' ? 'active' : '' }}"><i class="fas fa-cube"></i> @lang('messages.entity.unity')</a>
        <a href="{{ route('conversao.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'conversion_index' ? 'active' : '' }}"><i class="fas fa-exchange"></i> @lang('messages.entity.conversion')</a>
        <a href="{{ route('mother.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'mother_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.mother')</a>
    </ul>
    <a href="#customer" onclick="accordion('customer')" class="w3-bar-item w3-button {{ ($active ?? '') == 'customer' ? 'customer' : '' }}"><i class="fas fa-user"></i> @lang('messages.sidebar.customer')</a>
    <ul class="w3-hide" id="customer">
        <a href="{{ route('customer.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'customer_index' ? 'active' : '' }}"><i class="fas fa-list"></i> @lang('messages.sidebar.records')</a>
        <a href="{{ route('account.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'account_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.account')</a>
    </ul>
    <a href="#partner"  onclick="accordion('partener')" class="w3-bar-item w3-button {{ ($active ?? '') == 'partner' ? 'partner' : '' }}"><i class="fas fa-user"></i> @lang('messages.sidebar.partner')</a>
    <ul class="w3-hide" id="partner">
        <a href="{{ route('partner.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'partner_index' ? 'active' : '' }}"><i class="fas fa-list"></i> @lang('messages.sidebar.records')</a>
        <a href="{{ route('loan.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'loan_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.loan')</a>
        <a href="{{ route('devolution.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'return_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.return')</a>
    </ul>
    <a href="#server"  onclick="accordion('server')" class="w3-bar-item w3-button {{ ($active ?? '') == 'server' ? 'server' : '' }}"><i class="fas fa-truck"></i> @lang('messages.sidebar.server')</a>
    <ul class="w3-hide" id="server">
        <a href="{{ route('server.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'server_index' ? 'active' : '' }}"><i class="fas fa-list"></i> @lang('messages.sidebar.records')</a>
        <a href="{{ route('account.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'account_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.account')</a>
        <a href="{{ route('invoice.index') }}" class="w3-bar-item w3-button {{ ($subactive ?? '') == 'invoice_index' ? 'active' : '' }}"><i class="fas fa-file"></i> @lang('messages.entity.invoice')</a>
    </ul>

    <div class="w3-bar-item w3-display-bottommiddle w3-round-large w3-border-top w3-border-theme ">
        <div class="w3-flex" style="align-items: center; justify-content: space-between;">
            <button type="button" class=" w3-round-large w3-theme-l2"><i class="fas fa-power-off"></i> sair</button>
            <button type="button" class=" w3-round-large w3-theme-l2"><i class="fas fa-cog"></i></button>
        </div>
    </div>
    <a href="{{ route('store.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'store' ? 'active' : '' }}"><i class="fas fa-building"></i> @lang('messages.sidebar.store')</a>
    <a href="{{ route('stock.index') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'stock' ? 'active' : '' }}"><i class="fas fa-boxes"></i> @lang('messages.sidebar.stock')</a>
    <a href="{{ route('admin') }}" class="w3-bar-item w3-button {{ ($active ?? '') == 'credit' ? 'active' : '' }}"><i class="fas fa-users-cog"></i> @lang('messages.sidebar.admin')</a>
</div>