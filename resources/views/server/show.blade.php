@extends("server.indexServer")
@section("content-server")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$server->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$server->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$server->id}"; ?></label><br />
            <small>Entidade desde <?php echo $server->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_server')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $server->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Server"  />
            <input type="hidden" name="name" value="{{ $server->created_at->format('d-m-Y h:i') }}"  />
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
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-book text-dark"></i> Conta</a>
            </li>
            <li class="nav-item">
                <a href="#tab_3" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-book-open text-dark"></i> Facturas </a>
            </li>
            <li class="nav-item">
                <a href="#tab_4" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-coins text-dark"></i> Créditos </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('server.info')</div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('server.accounts')</div>
            <div role="tabpanel" class="tab-pane" id="tab_3" aria-labelledby="nav-contact-tab">@include('server.invoices')</div>
            <div role="tabpanel" class="tab-pane" id="tab_4" aria-labelledby="nav-contact-tab">@include('server.by_account')</div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
