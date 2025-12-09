<br />
<dl class="dl-horizontal">
    <div class="row">
        <div class="col">
            <dt>@lang('messages.cashier.user_id')</dt>
            <dd>{{ $cashier->user->name }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>@lang('messages.cashier.startime')</dt>
            <dd>{{ $cashier->startime ?? 'N/A' }}</dd>
        </div>
        <div class="col">
            <dt>@lang('messages.cashier.endtime')</dt>
            <dd>{{ $cashier->endtime ?? 'N/A' }}</dd>
        </div>    
    </div>
    <div class="row">
        <div class="col">
            <dt>@lang('messages.cashier.initial') (MT)</dt>
            <dd>{{ number_format($cashier->initial ?? 0, 2) }}</dd> 
        </div>
        <div class="col">
            <dt>@lang('messages.cashier.present') (MT)</dt>
            <dd>{{ number_format($cashier->present ?? 0, 2) }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>@lang('messages.cashier.informed') (MT)</dt>
            <dd>{{ number_format($cashier->informed ?? 0, 2) }}</dd> 
        </div>
        <div class="col">
            <dt>@lang('messages.cashier.missing') (MT)</dt>
            <dd>{{ number_format($cashier->missing ?? 0, 2) }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>@lang('messages.cashier.description')</dt>
            <dd>{{ $cashier->description ?? 'N/A' }}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <dt>@lang('messages.prompt.created')</dt>
            <dd>{{ $cashier->created_at->diffForHumans() }}</dd>
        </div>
    </div>
    <div class="row">
        <form  action="{{ route('cashier.destroy',$cashier->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
            @if($cashier->endtime != null)
            @can('cashier_destroy')<button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-warning"><i class="fa fa-trash-alt"> </i></button>@endcan

            <a href="{{ route('cashier.print', ['id' => $cashier->id]) }}" class="btn btn-danger ">
                <i class="fa fa-print"> </i>
            </a> 
            @else
            <a href="{{ route('cashier.edit', $cashier->id) }}" class="btn btn-primary">
                <i class="fas fa-boxes"> @lang('messages.payment.cashier_close')</i>
            </a>
            @endif
        </form>
        &nbsp;
        @can('audit_cashier')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $cashier->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Cashier"  />
            <input type="hidden" name="name" value="{{ $cashier->startime->format('d-m-Y h:i') }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
</dl>
