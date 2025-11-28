<div class="row">
    <div class="col">

        <div class="alert alert-danger">
            <strong>Aqui temos as facturas por serem eliminas. Esta operação é irreversível</strong>
        </div>
        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Utilizador</th>
                    <th>Motivo</th>
                    <th>Data</th>
                    <th>Apagar</th>
                    <th>NAO APAGAR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $key => $factura)
                <tr>            
                    <td>{{ $factura->customer_name }}</td>            
                    <td class="text-right">{{ number_format($factura->total ?? 0, 2) }}</td>
                    <td>{{ $factura->destroy_username }}</td>            
                    <td>{{ $factura->destroy_reason }}</td>            
                    <td>{{ $factura->destroy_date->format('d-m-Y') }}</td>        

                    @can('factura_total_destroy')                                          
                    <td class="btn-group-sm text-center">
                        <form  action="{{ route('factura.destroy',$factura->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"> </i>
                            </button>
                        </form>
                    </td>
                    <td class="btn-group-sm text-center">
                        <form  action="{{ route('factura.cancel.ask.destroy',$factura->id) }}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-times"> </i>
                            </button>
                        </form>
                    </td>
                    @endcan
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
                        {{ $facturas->appends(request()->input())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>