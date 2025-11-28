@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'partner';
    $subactive = 'partner_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-hands"> Painel do Parceiro  </i></h2>
                @include('partner.menuPartner')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-partner")                    
            </div>
        </div>
    </div>
</div>
@endsection
