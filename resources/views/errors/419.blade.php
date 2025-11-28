@extends("layouts.xicompra")
@section("content")
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    <h1 class="error-number">401</h1>
                    <h2>Login required</h2>
                    <p>In order to performe this action, login first... <br />
                        <a href="{{ route("home") }}" class="btn btn-outline-secondary">Home</a>
                    </p>

                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection