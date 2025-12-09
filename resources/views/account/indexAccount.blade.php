@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'account';
    $subactive = 'account_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book"> Painel de Contas  </i></h2>
                @include('account.menuAccount')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-account")                    
            </div>
        </div>
    </div>
</div>
@endsection
