@extends("partner.indexPartner")
@section("content-partner")
@php
$tabactive = session()->get('tab') ?? 'info';
@endphp
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$partner->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$partner->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$partner->id}"; ?></label><br />
            <small>Entidade desde <?php echo $partner->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_partner')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $partner->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Partner"  />
            <input type="hidden" name="name" value="{{ $partner->fullname }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'active' : '' }}"><i class="fa fa-info text-dark"></i> Informação</a>
            </li>
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'conta' : '' }}"><i class="fa fa-hand-holding text-dark"></i> Empréstimos </a>
            </li>
            <li class="nav-item">
                <a href="#tab_3" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'output' : '' }}"><i class="fa fa-download text-dark"></i> Devoluções </a>
            </li>     
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('partner.info')</div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab"></div>
            <div role="tabpanel" class="tab-pane" id="tab_3" aria-labelledby="nav-contact-tab"></div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
