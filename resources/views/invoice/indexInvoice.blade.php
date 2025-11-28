@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'invoice';
    $subactive = 'invoice_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file"> Facturas de Fornecedores  </i></h2>
                @include('invoice.menuInvoice')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-invoice")                    
            </div>
        </div>
    </div>
</div>
@endsection
