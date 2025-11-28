@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'customer';
    $subactive = 'customer_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user"> Painel do Cliente  </i></h2>
                @include('customer.menuCustomer')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-customer")                    
            </div>
        </div>
    </div>
</div>
@endsection
