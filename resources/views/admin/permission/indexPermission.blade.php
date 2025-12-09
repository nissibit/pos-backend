@extends('admin.index')
@section('content-admin')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-shield"> Painel de Permissoes </i></h2>
                @include('admin.permission.menuPermission')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-permission")                    
            </div>
        </div>
    </div>
</div>
@endsection
