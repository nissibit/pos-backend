<div class="row">
    <div class="col">
        <div class="alert alert-info">
            <strong>Histórico das facturas removidas</strong>
        </div>
<!--        <div class="form-group col input-group-sm">
            <form id="factura_search" role="form" autocomplete="off" action="{{ route('factura.search') }}" method="get" class="m-sm-1">
                <div class="input-group-sm input-group">
                    <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"> </i>
                        </button>
                    </span>
                </div>                                  
            </form>
        </div>-->
        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Utilizador</th>
                    <th>Motivo</th>
                    <th>Data do pedido</th>
                    <th>Data da Remoção</th>
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