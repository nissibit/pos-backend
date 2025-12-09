
<div class="row p-2">
    <div class="col-sm">
        <dl class="dl-horizontal">
            <dt>Nome do Parceiro</dt>
            <dd>{{ $loan->partner->fullname }}</dd>
            <dt>NUIT</dt>
            <dd>{{ $loan->partner->nuit }}</dd>
            <dt>Contacto</dt>
            <dd>{{ $loan->partner->phone }}</dd>                   
            <dt>Morada</dt>
            <dd>{{ $loan->partner->address }}</dd>         
        </dl>

        <div class="row">
            <div class="col-sm">
                @can('audit_loan')
                <form role='form' action="{{ route('audit.entity') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $loan->id }}"  />
                    <input type="hidden" name="model" value="\App\Models\Loan"  />
                    <input type="hidden" name="name" value="{{ $loan->partner->name }}"  />
                    <button type="submit" class="btn btn-primary">            
                        <i class="fa fa-user-shield"> auditar</i>
                    </button>
                </form>
                @endcan

            </div>
            <div class="col-sm text-left">
                <form  action="{{ route('loan.destroy',$loan->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    @can('loan_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Fundo?" class="btn btn-danger ml-2"><i class="fa fa-trash"> </i></button>@endcan
                </form>

            </div>
        </div>
    </div>
</div>
