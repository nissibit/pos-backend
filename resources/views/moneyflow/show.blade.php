@extends("moneyflow.indexMoneyFlow")
@section("content-moneyflow")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$moneyflow->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$moneyflow->id}"; ?></label><br />
            <label class="control-label"><strong>{{ "Código : " . $moneyflow->barcode != '' ? $moneyflow->barcode : $moneyflow->othercode }}</strong></label><br />
            <small>Entidade desde <?php echo $moneyflow->created_at->diffForHumans(); ?></small>
        </p>
         @can('audit_moneyflow')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $moneyflow->id }}"  />
            <input type="hidden" name="model" value="\App\Models\MoneyFlow"  />
            <input type="hidden" name="name" value="{{ $moneyflow->fund->startime->format('d-m-Y/ h:i') }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> Informação</a>
            </li>
            
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('moneyflow.info')</div>
         </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
