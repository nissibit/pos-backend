@extends("factura.indexFactura")
@section("content-factura")
<div class="card card-primary">    
    <div class="card-header">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> Por apagar</a>
            </li>
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-list text-dark"></i> Histórico</a>
            </li>
        </ul>

    </div>
    <div class="card-body tab-content p-2">
        <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('factura.por_apagar')</div>
        <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('factura.historico')</div>
    </div>
</div>
@endsection