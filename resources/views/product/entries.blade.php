<div class="card">
    <?php
    $total = $product->entries()->count();
    $entries = $product->entries()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Data</th>
                    <th>Qtd.</th>
                    <th>Armazem</th>
                    <th>Fornecedor</th>
                    <th>Preco Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalQtd = 0;
                $totalOldPrice = 0;
                $totalBuyingPrice = 0;
                $totalPrice = 0;
                $totalSubTotal = 0;
                $totalRate = 0;
                $i = 1;
                ?>
                @forelse($entries as $key => $entry)
                <?php $subtotal = $entry->buying_price * $entry->quantity;  ?>
                <tr>
                    <td>{{ $entry->product->name }}</td>
                    <td class="text-right">{{ $entry->created_at->format("d-m-Y") ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($entry->quantity, 2) }}</td>
                    <td class="text-right">{{ $entry->store->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ $entry->invoice->account->accountable->fullname ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($entry->buying_price ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($subtotal ?? 0, 2) }}</td> 
                    <?php
                    $totalQtd += $entry->quantity;
                    $totalPrice += $entry->buying_price;
                    $totalSubTotal += $subtotal;
                    $totalRate += $entry->rate * $subtotal % 100;
                    ?>
                    @empty
                <tr>
                    <td colspan="6" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total: </th>
                    <th class="text-right"class="text-right">{{ number_format($totalQtd,2) }}</th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right">{{ number_format($totalPrice,2) }}</th>
                    <th class="text-right">{{ number_format($totalSubTotal,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $entries->appends(request()->input())->appends('tab','stock')->links() }}
    </div>
</div>
