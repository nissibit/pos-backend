<div style="width: 100%; text-align: center; font-size: 16px">
    <strong>
        <div style="width: 100%;">
            {{ $company->description }}
        </div>
        
            <div style="width: 100%; ">
                {{ __('Volte sempre.') }}
            </div>
    </strong>
</div>

<div style="width:100%; font-size: 10px;">
    <div style="width: 70%; float:left; text-align: justify-all;">
        <strong>{{ 'Impresso por: '.auth()->user()->name }}</strong>
    </div>
    <div style="width: 30%; float: left; text-align: right;">
        <strong>{{ \Carbon\Carbon::now()->format('d-m-Y').' / '.\Carbon\Carbon::now()->format('h:i') }}</strong>        
    </div>
</div><br />
&nbsp;
