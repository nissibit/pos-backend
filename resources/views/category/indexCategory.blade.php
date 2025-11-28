@extends('layouts.xicompra')
@section('content')
<?php
    $active = 'product';
    $subactive = 'category_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cubes"> Painel da Categoria  </i></h2>
                @include('category.menuCategory')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-category")                    
            </div>
        </div>
    </div>
</div>
@endsection
