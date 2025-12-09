<div class="row">
    <div class="form-group col btn-group-sm">
        @can('create_product')   
        <a href="{{ route('mother.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a> 
        @endcan  
        <a href="{{ route('mother.index') }}" class="btn btn-outline-secondary ml">
            <i class="fas fa-list"> listar</i>
        </a>
    </div>    
    <div class="form-group col input-group-sm">
        <form id="unity_search" role="form" autocomplete="off" action="{{ route('mother.search') }}" method="get" class="m-sm-1">            
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
