@extends("layouts.xicompra")
@section("content")
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="card alert-danger">
            <div class="col-middle">
                <div class="text-center text-center">
                    <div class="card-header text-center">
                        <h2>404</h2>
                    </div>
                    <div class="card-body">
                        <h2>Page not found</h2>
                        <p>The requested url were not found,please check again an submit... <br />
                            <a href="{{ route("home") }}" class="btn btn-outline-secondary">Home</a>
                        </p>                    
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection