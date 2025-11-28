@extends('layouts.xicompra')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-shield"> Painel de Auditoria de Entidade  </i></h2>
                @include('audit.menuAudit')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-audit")                    
            </div>
        </div>
    </div>
</div>
@endsection
