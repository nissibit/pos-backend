@extends("admin.currency.indexCurrency")
@section("content-currency")
<table  class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Abreviatura</th>
            <th>Simbolo</th>
            <th></th>
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

            <td class="text-center">                                  
                <form  action="{{ route('currency.destroy',$currency->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    @can('currency_show')<a href="{{ route('currency.show', $currency->id) }}"><i class="fa fa-eye text-info"> </i></a>&nbsp;@endcan
                    @can('currency_edit')<a href="{{ route('currency.edit', $currency->id) }}"><i class="fa fa-edit text-success"> </i></a>&nbsp;@endcan
                    @can('currency_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>@endcan
                </form>
            </td>
        </tr>
        <?php $i++; ?>
         @empty
        <tr>
            <td colspan="5" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="5">  {{ $currencies->appends(request()->input())->links() }} </td>
        </tr>
    </tfoot>
</table> 
@endsection