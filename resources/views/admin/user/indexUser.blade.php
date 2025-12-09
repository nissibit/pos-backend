@extends('layouts.xicompra')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user"> Painel do Utilizador </i></h2>
                @include('admin.user.menuUser')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-user")                    
            </div>
        </div>
    </div>
</div>
@endsection
