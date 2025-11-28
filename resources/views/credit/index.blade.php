@extends("credit.indexCredit")
@section("content-credit")

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
            <th>Pagar</th>
            <th>Copiar</th>
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
            <td>
                @if($credit->payed)
                <a href="{{ route('payment.show', $credit->payments()->first() != null ? $credit->payments()->first()->id : 1) }}" class="btn btn-danger ">
                    <i class="fas fa-print"> </i>
                </a>
                @else
                <a href="{{ route('payment.create', ['credit' => $credit->id]) }}" class="btn btn-outline-primary ">
                    <i class="fas fa-arrow-right"> </i>
                </a>
                @endif
            </td>
            <td>
                <a href="{{ route('credit.copy', ['id' => $credit->id]) }}" class="btn btn-primary">
                    <i class="fas fa-copy"> </i>
                </a>
            </td>
        </tr>
        @php
        $i++;
        @endphp
        @empty
        <tr>
            <td colspan="8" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="7">  {{ $credits->appends(request()->input())->links() }} </td>
        </tr>

    </tfoot>
</table>
@endsection