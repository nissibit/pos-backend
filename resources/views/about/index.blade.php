@extends('layouts.xicompra')
<?php $active = 'about' ?>
@section('content')
<div class="card">
    <div class=" card-header">
        Acerca do Software
    </div>
    <div class="card-body">
        {{ config('app.name', 'Nissi Bit') }} &circledR;
        
        <div class="alert alert-light">
            <h2>{{ \Illuminate\Foundation\Inspiring::quote() }}</h2>
        </div>
    </div>
</div>
@endsection