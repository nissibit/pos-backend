@extends("mother.indexMother")
@section("content-product")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-cube fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$product->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$product->id}"; ?></label><br />
            <label class="control-label"><strong>{{ "Código : " . $product->barcode != '' ? $product->barcode : $product->othercode }}</strong></label><br />
            <small>Entidade desde <?php echo $product->created_at ?></small>
        </p>
        @can('audit_product')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $product->id }}"  />
            <input type="hidden" name="model" value="\App\Models\Product"  />
            <input type="hidden" name="name" value="{{ $product->name }}"  />
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
                <a href="#tab_2" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-building text-dark"></i> Stock</a>
            </li>  
            @can("delete_product")
            <li class="nav-item">
                <a href="#tab_3" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-download text-dark"></i> Entradas</a>
            </li>
            @endcan
            @can("edit_price")
            <li class="nav-item">
                <a href="#tab_4" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-dollar-sign text-dark"></i> Preços</a>
            </li>
            @endcan
            <li class="nav-item">
                <a href="#tab_5" data-toggle="tab" class="nav-item nav-link"><i class="fa fa-cube text-dark"></i> Retalho</a>
            </li>               
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">@include('product.info')</div>
            <div role="tabpanel" class="tab-pane" id="tab_2" aria-labelledby="nav-contact-tab">@include('product.stocks')</div>            
            @can("delete_product")
            <div role="tabpanel" class="tab-pane" id="tab_3" aria-labelledby="nav-contact-tab">@include('product.entries')</div>
            @endcan
            @can("edit_price")
            <div role="tabpanel" class="tab-pane" id="tab_4" aria-labelledby="nav-contact-tab">@include('product.prices')</div>
            @endcan
            <div role="tabpanel" class="tab-pane" id="tab_5" aria-labelledby="nav-contact-tab">@include('product.flap')</div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
