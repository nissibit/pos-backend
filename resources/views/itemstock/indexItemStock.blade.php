@extends("stocktaking.indexStockTaking")
@section("content-stocktaking")
<?php
    $active = 'itemstock';
    $subactive = 'itemstock_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-boxes"> Produtos do Inventário activo  </i></h2>
                @include('itemstock.menuItemStock')
            </div>
            <div class="card-body">
                
                @yield("content-itemstock")                    
            </div>
        </div>
    </div>
</div>
@endsection
