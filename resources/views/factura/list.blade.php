<div class="w3-grid-padding" style="grid-template-columns: auto;">
    <div id="factura-list">
        <div class="w3-card-2">
            <table class="w3-table-all w3-table-responsive w3-small w3-section">
                <thead>
                    <tr>
                        <th colspan="6">
                            <label>{{ $facturasHeader ?? '' }}</label>
                            <x-input type="text" placeholder="pesquisar..." oninput="w3.filterHTML('#id01', '.item', this.value)" />
                        </th>
                    </tr>
                    <tr class="w3-theme">
                        <th>Item</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Copiar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facturas as $key => $factura)
                    <tr class="w3-hover-theme">
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->customer_name }}</td>
                        <td>{{ $factura->customer_phone }}</td>
                        <td class="text-right">{{ number_format($factura->total ?? 0, 2) }}</td>
                        <td>{{ $factura->day->format('d-m-Y') }}</td>
                        <td class="btn-group-sm">
                            <a href="{{ route('factura.copy', ['id' => $factura->id]) }}" class="btn btn-primary">
                                <i class="fas fa-copy"> </i>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ $facturas->appends(request()->input())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>