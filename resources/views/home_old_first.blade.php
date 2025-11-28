@extends('layouts.app')
@section('content')
<div class="container">    
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-# active list-group-#-success"><i class="fa fa-user"> Clientes</i></a>
                <a href="{{ route("custommer.create") }}" class="list-group-#"> <i class="fa fa-plus"></i> Criar</a>
                <a href="{{ route("custommer.index") }}" class="list-group-#"> <i class="fa fa-info-circle"></i> Informações</a>
                <a href='{{ route("custommer.index") }}' class="list-group-#"> <i class="fa fa-list"></i> Listar</a>
            </div> 
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-# active list-group-#-info"><i class="fa fa-hand-holding-usd"> Crédito </i></a>
                <a href="{{ route("loan.create") }}" class="list-group-#"> <i class="fa fa-plus"></i> Novo</a>
                <a href='{{ route("loan.index") }}' class="list-group-#"> <i class="fa fa-money-bill"></i> Listar</a>
            </div> 
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-# active list-group-#-warning"><i class="fa fa-money-bill-alt"> Pagamentos</i></a>
                <a href="{{ route('new-payment') }}" class="list-group-#"> <i class="fa fa-plus"></i> Novo</a>
                <a href="{{ route('payment.index') }}" class="list-group-#"> <i class="fa fa-list"></i> Listar</a>
                <a href='{{ route("loan.index") }}' class="list-group-#"> <i class="fa fa-chart-bar"></i> Extrato</a>
            </div> 
        </div>
</div>
@endsection
