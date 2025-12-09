@extends('admin.index')
@section('content-admin')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-compress"> Painel da Restauração  </i></h2>
                @include('admin.restore.menuRestore')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-restore")                    
            </div>
        </div>
    </div>
</div>
@endsection
