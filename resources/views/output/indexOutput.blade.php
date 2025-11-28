@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'output';
    $subactive = 'output_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-handshake"> Painel de Outputs  </i></h2>
                @include('output.menuOutput')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-output")                    
            </div>
        </div>
    </div>
</div>
@endsection
