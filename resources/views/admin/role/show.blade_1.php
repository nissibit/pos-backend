@extends("admin.role.indexRole")
@section("content-role")
<div class="row">
    <div class="col-sm-3 text-center">
        <i class="fas fa-role fa-5x"></i>
        <p>
            <label class="control-label text-danger"><?php echo strtoupper("{$role->name}"); ?></label><br />
            <label class="control-label"><?php echo "Código : {$role->id}"; ?></label><br />
            <small>role desde <?php echo $role->created_at->diffForHumans(); ?></small>
        </p>
    </div> 
    <div class="col border-primary mb-2">        
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="nav-item active"><a href="#tab_1" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-info text-dark"></i> informação</a></li>
                <li class="nav-item"><a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-check text-dark"></i> perfil</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_1">@include("admin.role.info")</div>
                <div role="tabpanel" class="tab-pane " id="tab_2">@include("admin.role.users")</div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection
