@extends("admin.profissao.indexProfissao")
@section("content-profissao")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-user fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$profissao->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$profissao->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$profissao->cod}"; ?></label><br />
            <small> Profissão  desde <?php echo $profissao->created_at->diffForHumans(); ?></small>
        </p>
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-primaty"></i> informação</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include("admin.profissao.info")</div>            
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
