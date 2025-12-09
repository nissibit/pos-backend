@extends('credit.indexCredit')
@section('content-credit')
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
                    <th>Credito</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $key => $account)
                <?php
                $model = $account->accountable;
                $modelName = class_basename($model);
                $route = strtolower($modelName);
                ?>
                @if($route == "customer")
                <tr>
                    <td><a href="{{ route('credit.byaccount.create', ['id' => $account->id])}}">{{ $account->id }}</a></td>
                    <td><a href="{{ route('credit.byaccount.create', ['id' => $account->id]) }}">{{ $account->accountable->fullname }}</a></td>
                    <td><a href="{{ route('credit.byaccount.create', ['id' => $account->id]) }}">{{ $account->accountable->phone_nr }}</a></td>
                    <td class="text-right"><a href="{{ route('credit.byaccount.create', ['id' => $account->id]) }}">{{ number_format($account->discount ?? 0, 2) }}</a></td>                    
                    <td class="text-right"><a href="{{ route('credit.byaccount.create', ['id' => $account->id]) }}">{{ number_format($account->balance ?? 0, 2) }}</a></td>
                    <td>
                        <div class="form-inline">
                            <form id="account_search" role="form" autocomplete="off" action="{{ route('credit.create') }}" method="get" class="m-sm-1">
                                <div class="input-group-sm input-group">
                                    <input type="hidden" name="id"  value="{{ $account->id }}" >
                                    <span class="input-group-btn btn-group-sm ">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-plus-circle"> </i>
                                        </button>
                                    </span>
                                </div>                                  
                            </form>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-center"> {{ $accounts->appends(request()->input())->links() }}</td>
                </tr>
            </tfoot>

        </table>
    </div>
</div>
@endsection