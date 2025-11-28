@extends("account.indexAccount")
@section("content-account")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$account->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$account->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$account->id}"; ?></label><br />
            <small>Entidade desde <?php echo $account->created_at->diffForHumans(); ?></small>
        </p>
         @can('audit_account')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $account->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Account"  />
            <input type="hidden" name="name" value="{{ $account->accountable != NULL ? $account->accountable->fullname : 'N/A' }}"  />
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
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include('account.info')</div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
