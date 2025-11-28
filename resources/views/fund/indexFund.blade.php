@extends('layouts.xicompra')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-coins"> @lang('messages.sidebar.fund')</i></h2>
                @include('fund.menuFund')
            </div>
            <div class="card-body">
                @include('menu.alert')
                @yield("content-fund")                    
            </div>
        </div>
    </div>
</div>
@endsection
