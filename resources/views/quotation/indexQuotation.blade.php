@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'quotation';
    $subactive = 'quotation_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1 class="bg-primary text-center text-light" style="font-size: 50px;"><i class="fas fa-file text-uppercase"> Painel de Cotação  </i></h1>
                @include('quotation.menuquotation')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-quotation")                    
            </div>
        </div>
    </div>
</div>
@endsection
