@extends("admin.restore.indexRestore")
@section("content-restore")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-user fa-5x"></i>
        <p>
            <strong class="text-dark">{{ strtoupper("{$audit->tags}") }}</strong><br />
            <strong class="text-dark">{{ "#{$audit->id}" }}</strong><br />
            <strong class="text-dark">{{ $audit->user->name ?? '' }}</strong><br />
            <strong class="text-dark">{{ $audit->created_at ?? ''}}</strong><br />
        </p>
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-primaty"></i> informação</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include("admin.restore.info")</div>            
        </div>
    </div>
</div>
@endsection
