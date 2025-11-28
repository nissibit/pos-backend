<div class="row">
    <div class="form-group col btn-group-sm">
        @can('create_stock')
        <a href="{{ route('stock.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a> 
        @endcan
        <a href="{{ route('stock.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-list"> listar</i>
        </a>
        @can('create_product')
        <a href="{{ route('product.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> produto</i>
        </a>
        @endcan
        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> produto</i>
        </a>
    </div>
    <div class="form-group col input-group-sm">
        <form id="stock_search" role="form" autocomplete="off" action="{{ route('stock.search') }}" method="get" class="m-sm-1">
        
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
