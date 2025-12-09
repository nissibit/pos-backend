@extends('admin.factura.indexFactura')
@section('content-factura')

<table class="table table-bordered table-hover table-responsive-sm table-sm">           
    <thead>
        <tr>
            <th>Item</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Total</th>
            <th>Data Fact.</th>
            <th>Utilizador</th>
            <th>Data Remoção</th>
            <th>Restaurar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($facturas as $key => $factura)
        <?php
            $audit = $factura->audits()->latest()->first();
//            if($audit->event=="deleted"){
        ?>
        <tr>
            <td><a href="{{  route('report.pedido', ['id' => $factura->id]) }}">{{ $audit->event }}</a></td>
            <td><a href="{{  route('report.pedido', ['id' => $factura->id]) }}">{{ $factura->customer_name }}</a></td>
            <td><a href="{{  route('report.pedido', ['id' => $factura->id]) }}">{{ $factura->customer_phone }}</a></td>
            <td class="text-right"><a href="{{  route('report.pedido', ['id' => $factura->id]) }}">{{ number_format($factura->total ?? 0, 2) }}</a></td>
            <td><a href="{{  route('report.pedido', ['id' => $factura->id]) }}">{{ $factura->created_at->format('d-m-Y h:i') }}</a></td>                                
            <td class="btn-group-sm">
                {{ $audit->user->name }}
            </td>
             <td class="btn-group-sm">
                {{ $audit->created_at->format('d-m-Y h:i:s') }}
            </td>
            <td class="btn-group-sm">
                <a href="{{ route('restore.show', $audit->id) }}" class=" btn btn-primary">
                    <i class="fa fa-cogs"></i>
                </a>
            </td>
        </tr>

            <?php #} ?>
        @empty
        <tr>
            <td colspan="8" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8" class="text-center"> 
                {{ $facturas->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection