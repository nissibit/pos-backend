@extends("layouts.xicompra")
@section("content")
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    <h1 class="error-number">403</h1>
                    <h2>Accesso Negado</h2>
                    <p>Não tem permissão para realizar esta operação.. <br />
                        <a href="{{ route("voltar") }}" class="btn btn-outline-secondary"> voltar</a>
                    </p>
                    
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection