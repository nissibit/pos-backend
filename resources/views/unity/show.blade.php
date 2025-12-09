@extends("unity.indexUnity")
@section("content-unity")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$unity->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$unity->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$unity->id}"; ?></label><br />
            <small>Entidade desde <?php echo $unity->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_unity')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $unity->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Unity"  />
            <input type="hidden" name="name" value="{{ $unity->created_at->format('d-m-Y h:i') }}"  />
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
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-file text-dark"></i> Produtos</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include('unity.info')</div>
            <div role="tabpanel" class="tab-pane fade" id="tab_2" aria-labelledby="nav-contact-tab">@include('unity.products')</div>             
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
