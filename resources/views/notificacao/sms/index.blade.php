@extends("encaregado.indexEncaregado")
@section("content-encaregado")
<div class="row">
    <div class="col-sm-12">
        <?php
            $activo = (null != session('active')) ?  session('active') : 'tab_unico';
        ?>
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li role="presentation" class="{{ $activo=='tab_unico' ? 'active' : '' }}"><a href="#tab_unico" data-toggle="tab"><i class="fa fa-user text-primary"></i> Único</a></li>
                <li role="presentation" class="{{ $activo=='tab_todos' ? 'active' : '' }}"><a href="#tab_todos" data-toggle="tab"><i class="fa fa-users text-primary"></i> Todos/Grupo</a></li>
                <li class="pull-right">
                    <a href="{{ route("sms.encaregado") }}"><i class="fa fa-refresh text-primary"> </i></a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane {{ $activo=='tab_unico' ? 'active' : '' }}" id="tab_unico">@include("notificacao.sms.unico")</div>
                <div role="tabpanel" class="tab-pane fade {{ $activo=='tab_todos' ? 'active' : '' }}" id="tab_todos">@include("notificacao.sms.todos")</div>
            </div>
        </div>
    </div>
</div>

@endsection

