@extends("admin.currency.indexCurrency")
@section("content-currency")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Abreviatura</th>
            <th>Simbolo</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @forelse($currencies as $currency)
        <tr>
            <td><a href = "{{ route('currency.show', $currency->id) }}"> {{ $i }} </a></td>
            <td><a href = "{{ route('currency.show', $currency->id) }}"> {{ $currency->name }} </a></td>
            <td><a href = "{{ route('currency.show', $currency->id) }}"> {{ $currency->label }} </a></td>
            <td><a href = "{{ route('currency.show', $currency->id) }}"> {{ $currency->sign }}</a></td>
        </tr>
        <?php $i++; ?>
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $currencies->appends(request()->input())->links() }} </td>
        </tr>
    </tfoot>
</table> 
@endsection