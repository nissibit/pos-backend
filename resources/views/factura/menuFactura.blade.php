<div class="row">
    <div class="form-group col btn-group-sm">   
        @can('create_factura')
        <a href="{{ route('factura.create') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-plus-circle"> criar</i>
        </a>
        @endcan
        <a href="{{ route('factura.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-list"> listar</i>
        </a>
        @can("factura_total_destroy")
        <a href="{{ route('factura.view.ask.destroy') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fa fa-exclamation-triangle"> Por apagar</i>
        </a>
        <a href="{{ route('runoutsell.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fa fa-exclamation-circle"> Vendas sem Stock</i>
        </a>
        @endcan
    </div>
    
    <div class="form-group col input-group-sm">
        <form id="factura_search" role="form" autocomplete="off" action="{{ route('factura.search') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
