@extends('layouts.xicompra')
@section('content')
<?php
$active = 'admin';
$subactive = '';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users-cog"> Painel de Administração </i></h2>                
                @include('admin.menuAdmin')
            </div>
            <div class="card-body">
                @yield("content-admin")                    
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){ 
        $('.datepicker').datepicker({
            "dateFormat": 'yy-mm-dd',
            "changeMonth": true,
            "changeYear": true
        });
    })
</script>
@endsection
