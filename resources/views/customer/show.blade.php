@extends("customer.indexCustomer")
@section("content-customer")
@php
$tabactive = session()->get('tab') ?? 'info';
@endphp
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$customer->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$customer->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$customer->id}"; ?></label><br />
            <small>Entidade desde <?php echo $customer->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_customer')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $customer->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Customer"  />
            <input type="hidden" name="name" value="{{ $customer->fullname }}"  />
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
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'conta' : '' }}"><i class="fa fa-book text-dark"></i> Contas </a>
            </li>
            <li class="nav-item">
                <a href="#tab_3" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'output' : '' }}"><i class="fa fa-handshake text-dark"></i> Outputs </a>
            </li>
            <li class="nav-item">
                <a href="#tab_4" data-toggle="tab" class="nav-item nav-link {{ $tabactive == 'info' ? 'credito' : '' }}"><i class="fa fa-coins text-dark"></i> Créditos </a>
            </li>           
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('customer.info')</div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('customer.accounts')</div>
            <div role="tabpanel" class="tab-pane" id="tab_3" aria-labelledby="nav-contact-tab">@include('customer.outputs')</div>
            <div role="tabpanel" class="tab-pane" id="tab_4" aria-labelledby="nav-contact-tab">@include('customer.by_account')</div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
