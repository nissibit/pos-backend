@extends("category.indexCategory")
@section("content-category")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cubes fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$category->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$category->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$category->id}"; ?></label><br />
            <small>Entidade desde <?php echo $category->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_category')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $category->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Category"  />
            <input type="hidden" name="name" value="{{ $category->name }}"  />
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
            <div role="tabpanel" class="tab-pane active" id="tab_1"aria-labelledby="nav-contact-tab">@include('category.info')</div>
            <div role="tabpanel" class="tab-pane fade" id="tab_2" aria-labelledby="nav-contact-tab">@include('category.products')</div>             
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
