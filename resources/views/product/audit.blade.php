@extends("product.indexProduct")
@section("content-product")
<div class="card">
    <div class="card-header">
        <h2><i class="fa fa-user-shield"></i><strong> {{ $class.' : '.$name }} </strong></h2>
    </div>
    <div class="card-header">
        <div class="form-group col input-group-sm">
            <form id="unity_search" role="form" autocomplete="off" action="{{ route('product.search') }}" method="get" class="m-sm-1">            
                <div class="input-group-sm input-group">
                    <input type="text" name="criterio" class="form-control" placeholder="pesquisa auditoria" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"> </i>
                        </button>
                    </span>
                </div>                                  
            </form>
        </div>  
    </div>
    <div class="card-body">
        @include('audit.index')
    </div>
</div>
@endsection
