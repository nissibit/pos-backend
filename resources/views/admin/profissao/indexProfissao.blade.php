@extends('admin.index')
@section('content-admin')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file"> Painel de Profissão  </i></h2>
                @include('admin.profissao.menuProfissao')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-profissao")                    
            </div>
        </div>
    </div>
</div>
@endsection
