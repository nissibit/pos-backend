@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'server';
    $subactive = 'server_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users"> Painel do Fornecedor  </i></h2>
                @include('server.menuServer')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-server")                    
            </div>
        </div>
    </div>
</div>
@endsection
