<div class="card">
    @php
    $account = $server->account()->first();
    $credits = $account != null ? $account->credits()->latest()->paginate(10) : array()
    @endphp
    <div class="card-header">
        @if($account != null)
            <a href="{{ route('report.extrato.modelo_a4', $account->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-print"> Extrato M-A4</i>
            </a>
            <a href="{{ route('report.extrato.modelo_a5', $account->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-print"> Extrato M-A5</i>
            </a>
            <a href="{{ route('report.divida.modelo_a4', $account->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> Dívidas/M-A4</i>
            </a>
            <a href="{{ route('report.divida.modelo_a5', $account->id) }}" class="btn btn-outline-danger">
                <i class="fas fa-print"> Dívidas/M-A5</i>
            </a>
            @endif
    </div>
    <div class="card-header">
        <div class="form-group col input-group-sm">
            <form id="unity_search" role="form" autocomplete="off" action="{{ route('credit.search.by_account', ['id' => ($account != null ? $account->id : 0)]) }}" method="get" class="m-sm-1">
                <div class="input-group-sm input-group">
                    <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                    <input type="hidden" name="id" class="form-control" placeholder="pesquisa" required=""  value="{{ old('id', $account != null ? $account->id : '') }}" />
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"> </i>
                        </button>
                    </span>
                </div>                                  
            </form>
        </div> 
    </div> 
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Nr. Requisição</th>
                    <th>Nr. Factura</th>
                    <th>Total</th>
                    <th>Data Concepção</th>
                    <th>Data Limit pag</th>
                </tr>
            </thead>
            <tbody>


                @php
                $i = 1;
                @endphp
                @forelse($credits as $key => $credit)
                <tr>
                    <td><a href="{{ route('credit.show', $credit->id) }}">{{ $i }}</a></td>
                    <td><a href="{{ route('credit.show', $credit->id) }}">{{ $credit->account->accountable->fullname }}</a></td>
                    <td><a href="{{ route('credit.show', $credit->id) }}">{{ $credit->nr_requisicao }}</a></td>
                    <td><a href="{{ route('credit.show', $credit->id) }}">{{ $credit->nr_factura }}</a></td>
                    <td class="text-right"><a href="{{ route('credit.show', $credit->id) }}">{{ number_format($credit->total ?? 0, 2) }}</a></td>
                    <td class="text-right"><a href="{{ route('credit.show', $credit->id) }}">{{ $credit->day->format('d-m-Y') }}</a></td>                                
                    <td class="text-right"><a href="{{ route('credit.show', $credit->id) }}">{{ $credit->day->addDays($credit->account->days)->format('d-m-Y') }}</a></td>                                
                </tr>
                @php
                $i++;
                @endphp
                @empty
                <tr>
                    <td colspan="7" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-center"> 
                        @if(count($credits) > 0)
                        {{ $credits->appends(request()->input())->links() }}
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>