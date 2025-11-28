<div class="col">
    <div class="card">
        <?php
        $total = $currency->exchanges()->count();
        $exchanges = $currency->exchanges()->latest()->paginate(10);
        ?>
        <div class="card-header">
            {{ "Total :#".$total }}

        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive-sm table-sm">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Valor</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @forelse($exchanges as $key => $exchange)
                    <tr>
                        <td><a href="{{ route('exchange.show', $exchange->id) }}">{{ $i }}</a></td>
                        <td><a href="{{ route('exchange.show', $exchange->id) }}">{{ $exchange->amount }}</a></td>
                        <td class="text-right"><a href="{{ route('exchange.show', $exchange->id) }}">{{ $exchange->day->format('d-m-Y') }}</a></td>
                    </tr>
                    <?php $i++; ?>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center"> Sem registos ...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-center">
            {{ $exchanges->appends(request()->input())->links() }}
        </div>
    </div>
</div>
