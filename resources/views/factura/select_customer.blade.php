@extends('factura.indexFactura')
@section('content-factura')
<div class="card">
    <div class="card-header">
        <i class="fas fa-check"> Seleccionar Cliente</i>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Desconto</th>
                    <th>Saldo</th>
                    <th>facturao</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $key => $account)
               
                <tr>
                    <td><a href="{{ route('account.show', $account->id) }}">{{ $account->id }}</a></td>
                    <td><a href="{{ route('account.show', $account->id) }}">{{ $account->accountable->fullname }}</a></td>
                    <td><a href="{{ route('account.show', $account->id) }}">{{ $account->accountable->phone_nr }}</a></td>
                    <td class="text-right"><a href="{{ route('account.show', $account->id) }}">{{ number_format($account->discount ?? 0, 2) }}</a></td>                    
                    <td class="text-right">{{ number_format($account->balance ?? 0, 2) }}</td>
                    <td>
                        <div class="form-inline">
                            <form id="account_search" role="form" autocomplete="off" action="{{ route('factura.create') }}" method="get" class="m-sm-1">
                                <div class="input-group-sm input-group">
                                    <input type="hidden" name="id"  value="{{ $account->id }}" >
                                    <span class="input-group-btn btn-group-sm ">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                    </span>
                                </div>                                  
                            </form>
                            <div class="btn-group-sm">
                                <a href="{{ route('factura.by_account', $account->id) }}" class="btn btn-outline-primary  ml-1">
                                    <i class="fas fa-list"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            
        </table>
    </div>
</div>
@endsection