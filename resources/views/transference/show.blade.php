@extends("transference.indexTransference")
@section("content-transference")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cubes fa-5x"></i>
        <p>
            
            <label class="control-label"><?php echo "#{$transference->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$transference->id}"; ?></label><br />
            <small>Tranferencia desde <?php echo $transference->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_transference')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $transference->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Transference"  />
            <input type="hidden" name="name" value="{{ $transference->created_at->format('d-m-Y h:i') }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> Informação</a>
            </li>
            <li class="nav-item">
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-info text-dark"></i> Produtos</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('transference.info')</div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('transference.items')</div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
