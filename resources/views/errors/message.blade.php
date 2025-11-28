@extends("errors.header")
@section("content-error")
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    {{ e }}

                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection