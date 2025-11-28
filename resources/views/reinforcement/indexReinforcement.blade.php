@extends('fund.indexFund')
@section('content-fund')
<?php
    $active = 'reinforcement';
    $subactive = 'reinforcement_index';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-boxes"> Painel do Reforço  </i></h2>
                @include('reinforcement.menuReinforcement')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-reinforcement")                    
            </div>
        </div>
    </div>
</div>
@endsection
