@extends("factura.indexFactura")
@section("content-factura")
<div class="row">    
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> Informação</a>
            </li>
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-list text-dark"></i> Produtos</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">
                <div class="row">
                    <div class="col-sm-4">
                        @include('factura.info')
                    </div>
                    <div class="col">
                        <div class="alert alert-info">
                            <strong>Documento serve somente para levantar material</strong>
                        </div>
                        <iframe src="{{  route('report.pedido', ['id' => $factura->id]) }}" width="100%" height="600px">
                        </iframe>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('factura.items')</div>
        </div>
    </div>
</div>
@endsection
