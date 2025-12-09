@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'product';
    $subactive = 'unity_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cube"> Painel da Unidades  </i></h2>
                @include('unity.menuUnity')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-unity")                    
            </div>
        </div>
    </div>
</div>
@endsection
