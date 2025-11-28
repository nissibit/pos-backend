<nav id="sidebar" class="">
    <div class="sidebar-header text-center">
        <img src="{{ asset('img/logo.png') }}" class="img-responsive img-rounded">
        <!--<h3>{{-- config('app.name', 'Nissibit') --}}</h3>-->
        <!--<i class="fas fa-shopping-cart fa-5x text-success"></i>-->
        <strong>{{ config('app.short_name', 'NB')}}</strong>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ ($active ?? '') == 'home' ? 'active' : '' }}">
            <a href="{{ route('home') }}" >
                <i class="fas fa-home"></i>
                @lang('messages.sidebar.home')
            </a>
        </li>
        @can('menu_venda')        
        <li class="{{ ($active ?? '') == 'factura' ? 'active' : '' }}">
            <a href="{{ route('factura.index') }}">
                <i class="fa fa-shopping-cart"></i>
                @lang('messages.sidebar.sale')
            </a>
        </li>
        @endcan
        @can('menu_pag')   
        <li class="{{ ($active ?? '') == 'payment' ? 'active' : '' }}">
            <a href="{{ route('payment.index') }}">
                <i class="fa fa-dollar-sign"></i>
                @lang('messages.sidebar.payment')
            </a>
        </li>
        @endcan  
        @can('menu_fund')   
        <li class="{{ ($active ?? '') == 'fund' ? 'active' : '' }}">
            <a href="{{ route('fund.index') }}">
                <i class="fa fa-coins"></i>
                @lang('messages.sidebar.fund')
            </a>
        </li>
        @endcan  
        @can('menu_creditnote')   
        <li class="{{ ($active ?? '') == 'creditnote' ? 'active' : '' }}">
            <a href="{{ route('creditnote.index') }}">
                <i class="fa fa-folder"></i>
                @lang('messages.sidebar.creditnote')
            </a>
        </li>
        @endcan  
        @can("menu_output")
        <li class="{{ ($active ?? '') == 'output' ? 'active' : '' }}">
            <a href="{{ route('output.index') }}">
                <i class="fa fa-handshake"></i>
                @lang('messages.sidebar.output')
            </a>
        </li>
        @endcan
        @can("menu_quotation")
        <li class="{{ ($active ?? '') == 'quotation' ? 'active' : '' }}">
            <a href="{{ route('quotation.index') }}">
                <i class="fas fa-file"></i>
                @lang('messages.sidebar.quotation')
            </a>
        </li>
        @endcan
        @can("menu_credit")
        <li class="{{ ($active ?? '') == 'credit' ? 'active' : '' }}">
            <a href="{{ route('credit.index') }}">
                <i class="fas fa-coins"></i>
                @lang('messages.sidebar.credit')
            </a>
        </li>
        @endcan
        <li class="{{ ($active ?? '') == 'product' ? 'active' : '' }}">
            <a href="#product" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-cubes"></i>
                @lang('messages.sidebar.product')
            </a>
            <ul class="collapse list-unstyled" id="product">
                <li class="{{ ($subactive ?? '') == 'product_index' ? 'active' : '' }}">
                    <a href="{{ route('product.index') }}"> @lang('messages.sidebar.records')</a>
                </li>
                @can("menu_category")
                <li class="{{ ($subactive ?? '') == 'category_index' ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}"> @lang('messages.entity.category')</a>
                </li>
                @endcan
                @can("menu_unity")
                <li class="{{ ($subactive ?? '') == 'product_unity' ? 'active' : '' }}">
                    <a href="{{ route('unity.index') }}"> @lang('messages.entity.unity')</a>
                </li>
                @endcan
                @can("menu_conversion")
                <li class="{{ ($subactive ?? '') == 'product_conversao' ? 'active' : '' }}">
                    <a href="{{ route('conversao.index')}}">@lang('messages.entity.conversion') </a>
                </li>
                @endcan
                @can("principal_create")
                <li class="{{ ($subactive ?? '') == 'product_principal' ? 'active' : '' }}">
                    <a href="{{ route('mother.index') }}"> Principal</a>
                </li>
                @endcan
            </ul>
        </li>
        @can("menu_price")
        <li class="{{ ($active ?? '') == 'price' ? 'active' : '' }}">
            <a href="{{ route('price.index') }}">
                <i class="fas fa-dollar-sign"></i>
                @lang('messages.sidebar.price')
            </a>
        </li>
        @endcan
        @can("menu_customer")
        <li class="{{ ($active ?? '') == 'customer' ? 'active' : '' }}">
            <a href="#customer" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-user"></i>
                @lang('messages.sidebar.customer')
            </a>
            <ul class="collapse list-unstyled" id="customer">
                <li class="{{ ($subactive ?? '') == 'customer_index' ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}"> @lang('messages.sidebar.records')</a>
                </li>
                <li class="{{ ($subactive ?? '') == 'account_index' ? 'active' : '' }}">
                    <a href="{{ route('account.index') }}"> @lang('messages.entity.account')</a>
                </li>
            </ul>
        </li>
        @endcan
        @can("menu_partner")
        <li class="{{ ($active ?? '') == 'partner' ? 'active' : '' }}">
            <a href="#partner" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-user"></i>
                @lang('messages.sidebar.partner')
            </a>
            <ul class="collapse list-unstyled" id="partner">
                <li class="{{ ($subactive ?? '') == 'partner_index' ? 'active' : '' }}">
                    <a href="{{ route('partner.index') }}"> @lang('messages.sidebar.records')</a>
                </li>
                <li class="{{ ($subactive ?? '') == 'loan_index' ? 'active' : '' }}">
                    <a href="{{ route('loan.index') }}"> Empréstimos</a>
                </li>
                <li class="{{ ($subactive ?? '') == 'loan_index' ? 'active' : '' }}">
                    <a href="{{ route('devolution.index') }}"> Devoluções</a>
                </li>
            </ul>
        </li>
        @endcan
        @can("menu_supplier")
        <li class="{{ ($active ?? '') == 'server' ? 'active' : '' }}">
            <a href="#server" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-users"></i>
                @lang('messages.sidebar.server')
            </a>
            <ul class="collapse list-unstyled" id="server">
                <li class="{{ ($subactive ?? '') == 'server_index' ? 'active' : '' }}">
                    <a href="{{ route('server.index') }}"> @lang('messages.sidebar.records')</a>
                </li>
                <li class="{{ ($subactive ?? '') == 'account_index' ? 'active' : '' }}">
                    <a href="{{ route('account.index') }}"> @lang('messages.entity.account')</a>
                </li>
                <li class="{{ ($subactive ?? '') == 'invoice_index' ? 'active' : '' }}">
                    <a href="{{ route('invoice.index') }}"> @lang('messages.entity.invoice')</a>
                </li>
            </ul>
        </li>
        @endcan
        @can('menu_store')     
        <li class="{{ ($active ?? '') == 'store' ? 'active' : '' }}">
            <a href="{{ route('store.index') }}">
                <i class="fas fa-building"></i>
                @lang('messages.sidebar.store')
            </a>
        </li>
        @endcan
        @can("menu_stock")
        <li class="{{ ($active ?? '') == 'stock' ? 'active' : '' }}">
            <a href="{{ route('stock.index') }}">
                <i class="fas fa-boxes"></i>
                @lang('messages.sidebar.stock')
            </a>
        </li>
        @endcan
        @can('menu_admin')
        <li class="{{ ($active ?? '') == 'admin' ? 'active' : '' }}">
            <a href="{{ route('admin') }}">
                <i class="fas fa-users-cog"></i>
                @lang('messages.sidebar.admin')
            </a>
        </li>
        @endcan
        <li class="{{ ($active ?? '') == 'about' ? 'active' : '' }}">
            <a href="{{ route('about') }}">
                <i class="fas fa-info-circle"></i>
                @lang('messages.sidebar.about')
            </a>
        </li>
    </ul>
</nav>