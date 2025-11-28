@extends("errors.header")
@section("content-error")
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    <h1 class="error-number">404</h1>
                    <h2>Page not found</h2>
                    <p>The requested url were not found,please check again an submit... <br />
                        <a href="{{ route("home") }}" class="btn btn-outline-secondary">Home</a>
                    </p>
                    
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection