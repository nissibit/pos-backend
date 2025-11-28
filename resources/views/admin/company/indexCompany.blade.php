@extends('admin.index')
@section('content-admin')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-building"> Painel da Empresa  </i></h2>
                @include('admin.company.menuCompany')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-company")                    
            </div>
        </div>
    </div>
</div>
@endsection
