@extends("fund.indexFund")
@section("content-fund")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-file-archive fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$fund->name}"); ?></label><br />
            <label class="control-label"><?php echo "Código : {$fund->id}"; ?></label><br />
            <small>Fund desde <?php echo $fund->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_fund')
    <form role='form' action="{{ route('audit.entity') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $fund->id }}"  />
        <input type="hidden" name="model" value="\App\Models\Fund"  />
        <input type="hidden" name="name" value="{{ $fund->startime->format('d-m-Y h:i') }}"  />
        <button type="submit" class="btn btn-primary">            
            <i class="fa fa-user-shield"> auditar</i>
        </button>
    </form>
@endcan
    </div>
    <div class="col pb-2">
        <div class="col border-primary">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item ">
                    <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> informação</a>
                </li>
                <li class="nav-item">
                    <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-arrow-up text-dark"></i> Saídas</a> 
                </li>      
                <li class="nav-item">                   
                    <a href="#tab_3" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-coins text-dark"></i> Reforços</a>
                </li>
             </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active p-2" id="tab_1">@include("fund.info")</div>
                <div role="tabpanel" class="tab-pane " id="tab_2" aria-labelledby="nav-contact-tab">@include("fund.saidas")</div>
                <div role="tabpanel" class="tab-pane " id="tab_3" aria-labelledby="nav-contact-tab">@include("fund.reforcos")</div>
           </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
</div>

@endsection
