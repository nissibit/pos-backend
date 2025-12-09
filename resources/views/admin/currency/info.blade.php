<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $currency->name }}</dd>
            <dt>Abreviatura</dt>
            <dd>{{ $currency->label }}</dd>            
            <dt>Simbolo</dt>
            <dd>{{ $currency->sign }}</dd>
        </dl>
        @can('currency_edit')
        <a href="{{ route('currency.edit', $currency->id) }}" class="btn btn-outline-success">
            <i class="fas fa-edit"> </i>
        </a>
        @endcan
    </div>
</div>