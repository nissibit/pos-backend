@extends("admin.permission.indexPermission")
@section("content-permission")
<div class="row">
    <div class="col-sm-3 text-center">
        <i class="fas fa-user-shield fa-5x"></i>
        <p>
            <label class="control-label text-danger"><?php echo strtoupper("{$permission->name}"); ?></label><br />
            <label class="control-label"><?php echo "Código : {$permission->id}"; ?></label><br />
            <small>Permission desde <?php echo $permission->created_at->diffForHumans(); ?></small>
        </p>
    </div> 
    <div class="col border-primary mb-2">        
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="nav-item active"><a href="#tab_1" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-info text-dark"></i> informação</a></li>
                <li class="nav-item"><a href="#tab_3" data-toggle="tab" class="nav-item nav-link"><i class="fas fa-file text-dark"></i> Perfil</a></li>                              
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_1">@include("admin.permission.info")</div>
                <div role="tabpanel" class="tab-pane fade" id="tab_3">@include("admin.permission.roles")</div>             
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection
