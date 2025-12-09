@extends("admin.user.indexUser")
@section("content-user")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-user-plus fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$user->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$user->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$user->id}"; ?></label><br />
            <small>Entidade desde <?php echo $user->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_user')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id }}"  />
            <input type="hidden" name="model" value="\App\User"  />
            <input type="hidden" name="name" value="{{ $user->name }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-primaty"></i> Informação</a>
            </li>
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-file text-primaty"></i> Perfil</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include('admin.user.info')</div>
            <div role="tabpanel" class="tab-pane fade" id="tab_2" aria-labelledby="nav-contact-tab">@include('admin.user.roles')</div>             
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
