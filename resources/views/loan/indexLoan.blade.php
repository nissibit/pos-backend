@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'loan';
    $subactive = 'loan_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-dollar-sign"> Painel de Empréstimos  </i></h2>
                @include('loan.menuLoan')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-loan")                    
            </div>
        </div>
    </div>
</div>
@endsection
