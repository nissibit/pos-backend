<div class="card"  style="border: 1px #005C5F  solid ; border-radius: 5px; width: 100%; overflow: auto;">
    <div style="width: 50%; float: left;">
        <dl>
            <dd><img src="{{ asset('img/logo.png') }}" style="max-width: 25%"> </dd>      
            <dd>{{ $company->name }}</dd>
            <dd>{{ 'Tel: '.$company->tel.' / '.$company->otherPhone }}</dd>
            <dd>{{ 'Email: '.$company->email }}</dd>
            <dd>{{ 'Endereço: '.$company->address }}</dd>
            <dd>{{ 'NUIT: '.$company->nuit }}</dd>
        </dl>
    </div>
   
    <div style="clear: both"></div>
</div>
<div style="clear: both"></div>
<br />