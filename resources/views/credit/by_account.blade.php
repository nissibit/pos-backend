<div class="card">
    <h2>Extrato</h2>
    <a href="{{ route('report.credit', $credit->id) }}" class="btn btn-outline-danger">
        <i class="fas fa-print"> m-a4</i>
    </a>
    <a href="{{ route('report.credit.modelo_a5', $credit->id) }}" class="btn btn-outline-danger">
        <i class="fas fa-print"> m-a5</i>
    </a>
</div>
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
        </tr>
        @php
        $i++;
        @endphp
        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
</table>