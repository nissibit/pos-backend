@extends('admin.index')
@section('content-admin')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-upload"> Painel da Importação  </i></h2>
                @include('admin.import.menuImport')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-import")                    
            </div>
        </div>
    </div>
</div>
@endsection
