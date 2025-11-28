<div  style="border-botton: 1px #005C5F  solid ; border-radius: 5px;">
    <span><img src="{{ asset('img/logo.png') }}" style="max-width: 30%"> </span>  <br />            
    <span><strong style="font-size: 14pt;">{{ $company->name }}</strong></span>  <br />
    <span><span>Tel: </span>{{ $company->tel.' / '.$company->otherPhone }}</span>  <br />
    <span><span>Email: </span>{{ $company->email }}</span>  <br />
    <span><span>Endereço: </span>{{ $company->address }}</span>  <br />
    <span><span>NUIT: </span>{{ $company->nuit }}</span>  <br />
</div>