@extends('layouts.xicompra')
@section('content')
<?php
$active = 'home';
?>
<div class="container m-auto pt-3 ">       
    @if($products ?? null != null) 
    <div class="card"> 
        <div class="card-body">
            @include('home.stock')
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-sm-3 text-center">
            <h1>
                <span><i class="fa fa-smile fa-5x text-primary"></i></span><br />
                <span class="text-primary"> Bom dia! </span>                
            </h1>
        </div>
        <div class="col"></div>
        <div class="col-sm-3 text-right">
            <h1 class="text-center">
                <span><i class="fa fa-thumbs-up fa-5x text-primary "></i></span><br />
                <span class="text-primary text-uppercase">
                    Tenha um bom humor e um bom trabalho!
                </span>
            </h1>
        </div>
    </div>
    @endif
    <div class="alert alert-light">
        <h2>{{ \Illuminate\Foundation\Inspiring::quote() }}</h2>
    </div>
</div>
@endsection