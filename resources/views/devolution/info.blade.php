
<div class="row p-2">
    <div class="col-sm">
        <dl class="dl-horizontal">
            <dt>Nome do Parceiro</dt>
            <dd>{{ $devolution->loan->partner->fullname }}</dd>
            <dt>NUIT</dt>
            <dd>{{ $devolution->loan->partner->nuit }}</dd>
            <dt>Contacto</dt>
            <dd>{{ $devolution->loan->partner->phone }}</dd>                   
            <dt>Morada</dt>
            <dd>{{ $devolution->loan->partner->address }}</dd>         
        </dl>

        <div class="row">
            <div class="col-sm">
                @can('audit_devolution')
                <form role='form' action="{{ route('audit.entity') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $devolution->id }}"  />
                    <input type="hidden" name="model" value="\App\Models\Devolution"  />
                    <input type="hidden" name="name" value="{{ $devolution->loan->name }}"  />
                    <button type="submit" class="btn btn-primary">            
                        <i class="fa fa-user-shield"> auditar</i>
                    </button>
                </form>
                @endcan

            </div>
            <div class="col-sm text-left">
                <form  action="{{ route('devolution.destroy',$devolution->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    @can('devolution_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Fundo?" class="btn btn-danger ml-2"><i class="fa fa-trash"> </i></button>@endcan
                </form>

            </div>
        </div>
    </div>
</div>
