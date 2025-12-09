@extends("payment.cashier.indexCashier")
@section("content-cashier")
<?php
$tab = request()->get('tab');
$selectedTab = $tab != null ? $tab : 0;

?>
<div class="row">
    <div class="col pb-2">
        <div class="col border-primary">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a href="#tab_1" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 0 ? 'active': '' }}">@lang('messages.prompt.info')</li>
                <li class="nav-item"><a href="#tab_2" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 1 ? 'active': '' }}" ><i class="fas fa-coins text-dark"></i> @lang('messages.entity.sale')</a></li>
                <li class="nav-item"><a href="#tab_3" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 2 ? 'active': '' }}" ><i class="fas fa-coins text-dark"></i> @lang('messages.entity.credit')</a></li>
                <li class="nav-item"><a href="#tab_4" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 3 ? 'active': '' }}"><i class="fas fa-exchange-alt text-dark"></i> @lang('messages.entity.cashflow')</a></li>                
                <li class="nav-item"><a href="#tab_5" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 4 ? 'active': '' }}"><i class="fas fa-coins text-dark"></i> @lang('messages.item.total')</a></li>                
                <li class="nav-item"><a href="#tab_6" data-toggle="tab" class="nav-item nav-link {{ $selectedTab == 5 ? 'active': '' }}"><i class="fas fa-cubes text-dark"></i> @lang('messages.sale.products')</a></li>                
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 0 ? 'active': '' }}  p-2" id="tab_1">@include("payment.cashier.info")</div>
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 1 ? 'active': '' }}  p-2" id="tab_2"></div>
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 1 ? 'active': '' }}  p-2" id="tab_3"></div>
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 2 ? 'active': '' }}  p-2" id="tab_4">@include("payment.cashier.cashflow")</div>
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 3 ? 'active': '' }}  p-2" id="tab_5"></div>
                <div role="tabpanel" class="tab-pane {{ $selectedTab == 4 ? 'active': '' }}  p-2" id="tab_6"></div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        fetch_payments();
        fetch_totals();
        fetch_products();
        fetch_payment_credits();
    });
    async function fetch_payments(){
        let url = '{{route("cashier.payments",":id")}}';
        url = url.replace(":id", {{$cashier->id}});
        await fetch(url).then(res => res.text()).then( res => {
            document.querySelector("#tab_2").innerHTML = res;
        }).catch(error => console.log(error));
    }

    async function fetch_payment_credits(){
        let url = '{{route("cashier.payment.credits",":id")}}';
        url = url.replace(":id", {{$cashier->id}});
        await fetch(url).then(res => res.text()).then( res => {
            document.querySelector("#tab_3").innerHTML = res;
        }).catch(error => console.log(error));
    }

    async function fetch_totals(){
        let url = '{{route("cashier.totals",":id")}}';
        url = url.replace(":id", {{$cashier->id}});
        await fetch(url).then(res => res.text()).then( res => {
            document.querySelector("#tab_5").innerHTML = res;
        }).catch(error => console.log(error));
    }

    async function fetch_products(){
        let url = '{{route("cashier.products",":id")}}';
        url = url.replace(":id", {{$cashier->id}});
        await fetch(url).then(res => res.text()).then( res => {
            document.querySelector("#tab_6").innerHTML = res;
        }).catch(error => console.log(error));
    }
</script>
@endsection
