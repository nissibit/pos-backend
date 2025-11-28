@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'conversao';
    $subactive = 'conversao_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book"> Painel de Conversão   </i></h2>
                @include('conversao.menuConversao')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-conversao")                    
            </div>
        </div>
    </div>
</div>
@endsection
