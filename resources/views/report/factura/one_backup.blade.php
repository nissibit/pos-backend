<?php
//$customer = $factura->account->accountable;
?>

<style>
    body{
        font-family: 'arial';
        font-size: 14px;
        top:0px;
        
    }

</style>
<body>
    <div  style="border-botton: 1px #005C5F  solid ; border-radius: 5px;">
        <span><img src="{{ asset('img/logo.png') }}" style="max-width: 30%"> </span>  <br />    
        <span>{{ $company->name }}</span>  <br />
        <span>{{ 'Tel: '.$company->tel.' / '.$company->otherPhone }}</span>  <br />
        <span>{{ 'Email: '.$company->email }}</span>  <br />
        <span>{{ 'Endereço: '.$company->address }}</span>  <br />
        <span>{{ 'NUIT: '.$company->nuit }}</span>  <br />
    </div>
    <br />
    @include('report.factura.items')
    <br /><br />

    <div style="text-align: center;">
        <strong>Assinatura e Carimbo</strong>
        <br /><br />_____________________<br />
        ({{ __('O responável')}})
    </div>
    <br /><br />

    @include('report.footer')
</body>