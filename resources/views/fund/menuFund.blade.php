<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
        color:black;
    }
</style>
@php
$fund = auth()->user()->fund->where('endtime', null)->first();
$open = ($fund != null) ? $fund->count() : 0;
@endphp
<div class="form-group row">
    <div class="form-group col-sm-4 btn-group-sm"> 
        @if($open == 0)
        <a href="{{ route('fund.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus-circle"> abrir fundo</i>
        </a>
        @else  
        <a href="{{ route('moneyflow.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> Saídas</i>
        </a> 
        <a href="{{ route('reinforcement.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-hand"> Reforços</i>
        </a> 
        @endif
        <a href="{{ route('fund.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> Listar todos fundos</i>
        </a>
    </div>
    @can('search_fund')
    <div class="form-group col input-group-sm bg-white">
        <form id="fund_search" role="form" autocomplete="off" action="{{ route('fund.search.report') }}" method="get" class="m-sm-1">
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
        <form id="fund_search" role="form" autocomplete="off" action="{{ route('fund.search') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisar..." required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
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
        document.addEventListener('DOMContentLoaded', function(){ 

            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: '0D',
                changeYear: true,
                changeMonth: true
            });
        });
</script>