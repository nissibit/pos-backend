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
                        <th>ver / copiar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facturas as $key => $factura)
                    <tr class="w3-hover-theme">
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->customer_name }}</td>
                        <td>{{ $factura->customer_phone }}</td>
                        <td class="text-right">{{ number_format($factura->total ?? 0, 2) }}</td>
                        <td>{{ $factura->created_at->format('d-m-Y h:i') }}</td>
                        <td>
                            <div class="w3-tiny w3-flex" style="align-items: center; gap: 4px;">
                                <x-button onclick="displayFactura('{{$factura->id}}')"><i class="fas fa-eye"></i></x-button>
                                <x-button onclick="copyFactura('{{$factura->id}}')"><i class="fas fa-copy"></i></x-button>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>