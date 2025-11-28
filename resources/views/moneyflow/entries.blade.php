<div class="card">
    <?php
    $total = $moneyflow->entries()->count();
    $entries = $moneyflow->entries()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Qtd.</th>
                    <th>Armazem</th>
                    <th>Fornecedor</th>
                    <th>Preco Unitario</th>
                    <th>Taxa (%)</th>
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
                ?>
                @forelse($entries as $key => $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->moneyflow->name }}</td>
                    <td>{{ $entry->quantity }}</td>
                    <td class="text-right">{{ $entry->store->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ $entry->invoice->account->accountable->fullname ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($entry->current_price ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->rate ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->subtotal ?? 0, 2) }}</td>   
                    <?php
                    $totalQtd += $entry->quantity;
                    $totalOldPrice += $entry->old_price;
                    $totalBuyingPrice += $entry->buying_price;
                    $totalPrice += $entry->current_price;
                    $totalRate += ($entry->subtotal * $entry->rate) / 100;
                    $totalSubTotal += $entry->subtotal;
                    ?>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Totais</th>
                    <th class="text-right">{{ number_format($totalQtd,2) }}</th>
                    <th class="text-right">{{ number_format($totalOldPrice,2) }}</th>
                    <th class="text-right">{{ number_format($totalBuyingPrice,2) }}</th>
                    <th class="text-right">{{ number_format($totalPrice,2) }}</th>
                    <th class="text-right">{{ number_format($totalRate,2) }}</th>
                    <th class="text-right">{{ number_format($totalSubTotal,2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $entries->appends(request()->input())->links() }}
    </div>
</div>
