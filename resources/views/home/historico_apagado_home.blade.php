@extends('layouts.xicompra')
@section('content')
<?php
$active = 'home';
?>
<div class="container m-auto pt-3 ">   

    <div class="card">
        <div class="card-header">
            <strong>Histórico das facturas removidas em {{ $date }}</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive-sm table-sm">           
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Utilizador</th>
                        <th>Motivo</th>
                        <th>Data do pedido</th>
                        <th>Data e hora da Remoção</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashes as $key => $trash)
                    <tr>            
                        <td>{{ $trash->customer_name }}</td>            
                        <td class="text-right">{{ number_format($trash->total ?? 0, 2) }}</td>
                        <td>{{ $trash->destroy_username }}</td>            
                        <td>{{ $trash->destroy_reason }}</td>            
                        <td>{{ $trash->destroy_date->format('d-m-Y') }}</td>        
                        <td>{{ $trash->deleted_at->format('d-m-Y h:i:s') }}</td> 
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7  " class="text-center"> 
                            {{ $trashes->appends(request()->input())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection