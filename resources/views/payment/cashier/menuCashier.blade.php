<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
        color:black;
    }
</style>
<div class="form-group row">
    <div class="form-group col-sm-4 btn-group-sm"> 
        @if($open == 0)
        @can("create_cashier")
        <a href="{{ route('cashier.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-boxes"> @lang('messages.payment.cashier_open')</i>
        </a>
        @endif
        @endcan
        @can("list_cashier")
        <a href="{{ route('cashier.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> @lang('messages.payment.cashiers')</i>
        </a>
    </div>
    @endcan
    @can('search_cashier')
    <div class="form-group col input-group-sm bg-white">
        <form id="cashier_search" role="form" autocomplete="off" action="{{ route('cashier.search.report') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="from" class="form-control datepicker" placeholder="Y-m-d" required=""  value="{{ old('from', $dados['from'] ?? '') }}" readonly="readonly" /> &nbsp; - &nbsp;
                <input type="text" name="to" class="form-control datepicker" placeholder="Y-m-d" required=""  value="{{ old('to', $dados['to'] ?? '') }}" readonly="readonly" />
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>     
    <div class="form-group col-sm-3 input-group-sm">
        <form id="cashier_search" role="form" autocomplete="off" action="{{ route('cashier.search') }}" method="get" class="m-sm-1">
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
    @endcan
</div> 
<script type="text/javascript">
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0D',
        changeYear: true,
        changeMonth: true
    });
</script>