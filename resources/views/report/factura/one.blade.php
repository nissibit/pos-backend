<?php
//$customer = $factura->account->accountable;
?>

<style>
    @page{
        margin-top: 20px;
    }
    #body{
        font-family: 'arial';
        font-size: 14px;
        top:-10px;
        
    }

</style>
<div id="body">
<div>
    <span><img src="{{ asset('img/logo.png') }}" style="max-width: 30%"> </span>  <br />            
    <span><strong style="font-size: 14pt;">{{ $company->name }}</strong></span>  <br />
    <span><span>Tel: </span>{{ $company->tel.' / '.$company->otherPhone }}</span>  <br />
    <span><span>Email: </span>{{ $company->email }}</span>  <br />
    <span><span>Endereço: </span>{{ $company->address }}</span>  <br />
    <span><span>NUIT: </span>{{ $company->nuit }}</span>  <br />
</div><br />
@include('report.factura.items')
<div style="text-align: center;">
    <strong>Assinatura e Carimbo</strong>
  <br />_____________________<br />
    ({{ __('O responsável')}})
</div>
    @include('report.footer')
</div>