@extends("exchange.indexExchange")
@section("content-exchange")
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>Data</th>
            <th>Moeda</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @forelse($exchanges as $exchange)
        <tr>
            <td><a href="{{ route('exchange.show', $exchange->id) }}">{{ $exchange->day->format('d-m-Y') }}</a></td>            
            <td><a href="{{ route('exchange.show', $exchange->id) }}"> {{ $exchange->currency->name }} </a></td>
            <td><a href="{{ route('exchange.show', $exchange->id) }}"> {{ number_format($exchange->amount ?? 0, 2) }} </a></td>
        </tr> 
        @empty
        <tr>
            <td colspan="3" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-center">
                {{ $exchanges->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table> 
@endsection