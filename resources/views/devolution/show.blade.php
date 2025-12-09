@extends("devolution.indexDevolution")
@section("content-devolution")
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
                        @include('devolution.info')
                    </div>
                    <div class="col">
                        <iframe src="{{  route('report.devolution', ['id' => $devolution->id]) }}" width="100%" height="700px">
                        </iframe>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('devolution.items')</div>
        </div>
    </div>
</div>
@endsection
